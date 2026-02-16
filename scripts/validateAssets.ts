#!/usr/bin/env node
// @ts-nocheck
"use strict";

const fs = require("node:fs");
const path = require("node:path");
const vm = require("node:vm");
const ts = require("typescript");

const repoRoot = path.resolve(__dirname, "..");
const registryFilePath = path.join(repoRoot, "src", "assets", "assetRegistry.ts");
const publicRoot = path.join(repoRoot, "public");

function loadAssetsFromRegistry() {
  if (!fs.existsSync(registryFilePath)) {
    throw new Error(`Asset registry not found: ${registryFilePath}`);
  }

  const source = fs.readFileSync(registryFilePath, "utf8");
  const transpiled = ts.transpileModule(source, {
    compilerOptions: {
      module: ts.ModuleKind.CommonJS,
      target: ts.ScriptTarget.ES2020,
    },
    fileName: registryFilePath,
    reportDiagnostics: false,
  });

  const sandbox = {
    module: { exports: {} },
    exports: {},
    require,
    console,
    process,
  };
  sandbox.exports = sandbox.module.exports;

  vm.runInNewContext(transpiled.outputText, sandbox, { filename: registryFilePath });

  const exported = sandbox.module.exports;
  if (!exported || !exported.ASSETS) {
    throw new Error("ASSETS export was not found in assetRegistry.ts");
  }

  return exported.ASSETS;
}

function resolvePublicPath(assetPath) {
  const relative = String(assetPath).replace(/^\/+/, "");
  const resolved = path.resolve(publicRoot, relative);
  const normalizedPublicRoot = path.resolve(publicRoot);

  if (resolved !== normalizedPublicRoot && !resolved.startsWith(`${normalizedPublicRoot}${path.sep}`)) {
    throw new Error(`Path escapes public root: ${assetPath}`);
  }

  return resolved;
}

function validateCategory(category, items, missing, invalid) {
  if (!Array.isArray(items)) {
    invalid.push({
      category,
      id: "(invalid)",
      assetPath: "(invalid)",
      reason: "Category is not an array",
    });
    return;
  }

  for (const item of items) {
    if (!item || typeof item.id !== "string" || typeof item.path !== "string") {
      invalid.push({
        category,
        id: item && item.id ? String(item.id) : "(invalid)",
        assetPath: item && item.path ? String(item.path) : "(invalid)",
        reason: "Item must include string id and path",
      });
      continue;
    }

    let expectedPath;
    try {
      expectedPath = resolvePublicPath(item.path);
    } catch (error) {
      invalid.push({
        category,
        id: item.id,
        assetPath: item.path,
        reason: error instanceof Error ? error.message : String(error),
      });
      continue;
    }

    if (!fs.existsSync(expectedPath)) {
      missing.push({
        category,
        id: item.id,
        assetPath: item.path,
        expectedPath,
      });
    }
  }
}

function main() {
  if (!fs.existsSync(publicRoot)) {
    console.error(`[assets:validate] Missing public directory: ${publicRoot}`);
    process.exit(1);
  }

  const assets = loadAssetsFromRegistry();
  const missing = [];
  const invalid = [];

  validateCategory("backgrounds", assets.backgrounds, missing, invalid);
  validateCategory("graphics", assets.graphics, missing, invalid);
  validateCategory("heroes", assets.heroes, missing, invalid);
  validateCategory("icons", assets.icons, missing, invalid);
  validateCategory("laptopui", assets.laptopui, missing, invalid);
  validateCategory("logo", [assets.logo], missing, invalid);

  const totalAssets =
    (Array.isArray(assets.backgrounds) ? assets.backgrounds.length : 0) +
    (Array.isArray(assets.graphics) ? assets.graphics.length : 0) +
    (Array.isArray(assets.heroes) ? assets.heroes.length : 0) +
    (Array.isArray(assets.icons) ? assets.icons.length : 0) +
    (Array.isArray(assets.laptopui) ? assets.laptopui.length : 0) +
    1;

  if (invalid.length > 0) {
    console.error("[assets:validate] Invalid asset entries:");
    for (const item of invalid) {
      console.error(`- ${item.category}:${item.id} -> ${item.assetPath} (${item.reason})`);
    }
    process.exit(1);
  }

  if (missing.length > 0) {
    console.error(`[assets:validate] Missing ${missing.length} asset file(s):`);
    for (const item of missing) {
      console.error(`- ${item.category}:${item.id} -> ${item.assetPath}`);
      console.error(`  expected: ${item.expectedPath}`);
    }
    process.exit(1);
  }

  console.log(`[assets:validate] OK: ${totalAssets} assets validated and all files exist under /public`);
}

main();
