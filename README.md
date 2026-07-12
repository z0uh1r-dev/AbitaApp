# AbitaApp — Monorepo

This repository hosts both halves of the ABITA platform, deployed
**independently** to the same or different VPS targets.

```
AbitaApp/
├── admin/    # Laravel backend (AbitaDash) — API + admin panel
│              see admin/DEPLOYMENT.md
└── public/   # Next.js frontend (customer-facing site)
               see public/DEPLOYMENT.md
```

## For deploying agents (Claude Code, etc.)

- **Backend deployment**: follow `admin/DEPLOYMENT.md` step-by-step.
- **Frontend deployment**: follow `public/DEPLOYMENT.md` step-by-step.
- Each app has its own `deploy.sh`, `.env.*.example`, and GitHub Actions
  workflow (`.github/workflows/deploy.yml` for the backend,
  `.github/workflows/deploy-frontend.yml` for the frontend), and can be
  deployed to the same VPS (different paths/ports) or separate VPS instances.
- Never invent credentials, domains, or paths — always ask the user for
  missing values before proceeding.
