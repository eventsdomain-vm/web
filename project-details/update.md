_headers file
https://project.pages.dev/*
  X-Robots-Tag: noindex


I have a production website running on Cloudflare Pages with a custom domain.

Primary Domain:
https://eventsdomain.com

Cloudflare Pages Deployment URL:
https://eventsdomain.pages.dev

I want search engines to index ONLY my production domain (eventsdomain.com) and NEVER index the pages.dev deployment URLs or preview deployments.

Generate a production-ready Cloudflare Pages `_headers` file that:

- Adds `X-Robots-Tag: noindex` for all `*.pages.dev` URLs.
- Covers both the main pages.dev domain and preview deployment URLs.
- Does NOT affect my custom domain (eventsdomain.com).
- Follows the latest Cloudflare Pages `_headers` syntax and best practices.
- Explain each rule with comments.
- Also tell me where to place the `_headers` file depending on whether I'm using Astro, Next.js, React, Vite, or a static HTML project.

Additionally, recommend any other SEO-related headers or Cloudflare best practices to prevent duplicate content between the pages.dev domain and the production domain.