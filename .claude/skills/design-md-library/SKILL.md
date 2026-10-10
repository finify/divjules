---
name: design-md-library
description: A vendored library of 73 brand DESIGN.md files (Linear, Stripe, Vercel, Notion, Apple, Airbnb, Raycast, Supabase, and more) — each a plain-text design system defining that brand's color, type, spacing, motion, and component rules. Use when the user asks to build or restyle UI "like <brand>", wants a reference design language for a page or component, or asks what design languages are available in this project. Read the specific brand's DESIGN.md before writing any markup or styles.
---

# DESIGN.md Library

73 brand design systems vendored from [awesome-design-md](https://github.com/VoltAgent/awesome-design-md),
at `.claude/design-md/<brand>/DESIGN.md`.

## How to use

1. **Find the brand.** `.claude/design-md/INDEX.md` lists every available brand and its path.
   If the user names a brand not in the index, say so and offer the closest match rather than improvising.
2. **Read the whole file** for the chosen brand before writing any UI. These files are 400-600 lines
   and carry exact tokens — hex values, type scales, spacing steps, radii, shadow recipes, easing
   curves. Paraphrasing from memory defeats the purpose; the specificity is the value.
3. **Apply the tokens literally.** Use the file's actual values, not your approximation of the vibe.
4. **Adapt to this project's stack**, which is Nuxt 3 + Vue + Tailwind (`toptab-web/tailwind.config.js`).
   Prefer expressing the brand's tokens as Tailwind theme extensions over scattered inline styles,
   so the design language is reusable across components.

## Choosing when the user hasn't named a brand

Ask. Do not silently pick one — these design languages are strongly opinionated and pull a product
in very different directions. Offer 2-3 candidates that fit the described audience and product type.

## Scope

This is a reference library, not a mandate. It applies when the user is asking for a specific brand's
look. For general UI craft and motion quality, use `emil-design-eng`, `apple-design`, and `animate`.
An active project-wide design language belongs in a root `DESIGN.md`, not here.
