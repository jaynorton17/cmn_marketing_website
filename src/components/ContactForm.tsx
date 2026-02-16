"use client";

import { FormEvent, useState } from "react";

type ContactValues = {
  name: string;
  email: string;
  organisation: string;
  message: string;
};

type ContactErrors = Partial<Record<keyof ContactValues, string>>;

const INITIAL_VALUES: ContactValues = {
  name: "",
  email: "",
  organisation: "",
  message: "",
};

function validate(values: ContactValues): ContactErrors {
  const errors: ContactErrors = {};

  if (!values.name.trim()) {
    errors.name = "Name is required.";
  }

  if (!values.email.trim()) {
    errors.email = "Email is required.";
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(values.email)) {
    errors.email = "Enter a valid email address.";
  }

  if (!values.organisation.trim()) {
    errors.organisation = "Organisation is required.";
  }

  if (!values.message.trim()) {
    errors.message = "Message is required.";
  }

  return errors;
}

export default function ContactForm() {
  const [values, setValues] = useState<ContactValues>(INITIAL_VALUES);
  const [errors, setErrors] = useState<ContactErrors>({});
  const [submitted, setSubmitted] = useState(false);

  function handleSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();

    const validationErrors = validate(values);
    setErrors(validationErrors);

    if (Object.keys(validationErrors).length > 0) {
      setSubmitted(false);
      return;
    }

    setSubmitted(true);
    setErrors({});
    setValues(INITIAL_VALUES);
  }

  function setField<K extends keyof ContactValues>(field: K, value: ContactValues[K]) {
    setValues((current) => ({ ...current, [field]: value }));
    setErrors((current) => ({ ...current, [field]: undefined }));
  }

  return (
    <div className="contact-form-wrap shell-stack">
      {submitted ? (
        <div className="contact-success" role="status" aria-live="polite">
          Thanks, your message has been received. We will be in touch shortly.
        </div>
      ) : null}

      <form className="contact-form shell-stack" onSubmit={handleSubmit} noValidate>
        <div className="contact-field shell-stack">
          <label htmlFor="contact-name">Name</label>
          <input
            id="contact-name"
            name="name"
            type="text"
            value={values.name}
            autoComplete="name"
            required
            onChange={(event) => setField("name", event.target.value)}
            aria-invalid={errors.name ? "true" : "false"}
            aria-describedby={errors.name ? "contact-name-error" : undefined}
          />
          {errors.name ? (
            <p id="contact-name-error" className="contact-error" role="alert">
              {errors.name}
            </p>
          ) : null}
        </div>

        <div className="contact-field shell-stack">
          <label htmlFor="contact-email">Email</label>
          <input
            id="contact-email"
            name="email"
            type="email"
            value={values.email}
            autoComplete="email"
            required
            onChange={(event) => setField("email", event.target.value)}
            aria-invalid={errors.email ? "true" : "false"}
            aria-describedby={errors.email ? "contact-email-error" : undefined}
          />
          {errors.email ? (
            <p id="contact-email-error" className="contact-error" role="alert">
              {errors.email}
            </p>
          ) : null}
        </div>

        <div className="contact-field shell-stack">
          <label htmlFor="contact-organisation">Organisation</label>
          <input
            id="contact-organisation"
            name="organisation"
            type="text"
            value={values.organisation}
            autoComplete="organization"
            required
            onChange={(event) => setField("organisation", event.target.value)}
            aria-invalid={errors.organisation ? "true" : "false"}
            aria-describedby={errors.organisation ? "contact-organisation-error" : undefined}
          />
          {errors.organisation ? (
            <p id="contact-organisation-error" className="contact-error" role="alert">
              {errors.organisation}
            </p>
          ) : null}
        </div>

        <div className="contact-field shell-stack">
          <label htmlFor="contact-message">Message</label>
          <textarea
            id="contact-message"
            name="message"
            rows={5}
            value={values.message}
            required
            onChange={(event) => setField("message", event.target.value)}
            aria-invalid={errors.message ? "true" : "false"}
            aria-describedby={errors.message ? "contact-message-error" : undefined}
          />
          {errors.message ? (
            <p id="contact-message-error" className="contact-error" role="alert">
              {errors.message}
            </p>
          ) : null}
        </div>

        <div>
          <button className="btn btn--primary" type="submit">
            Send message
          </button>
        </div>
      </form>
    </div>
  );
}
