# SDA Church CMS - Design System

## Core Brand Identity
The SDA Church CMS uses a design system strictly aligned with the Seventh-day Adventist branding. Avoid all legacy generic colors (especially purples/indigos).

### Colors
**1. Primary (SDA Brand Green)**
- **Hex:** `#2E5F3B`
- **Tailwind Classes:** `text-primary`, `bg-primary`, `border-primary`
- **Usage:** Main brand color. Used for prominent UI elements like primary buttons, headers, active states, and core branding.

**2. Secondary (SDA Brand Gold)**
- **Hex:** `#E3A82B`
- **Tailwind Classes:** `text-secondary`, `bg-secondary`, `border-secondary`
- **Usage:** Accent color. Used for secondary buttons, highlights, badges, icons, and elements that need to draw attention without overpowering the green.

**3. Neutral (SDA Brand Gray)**
- **Hex:** `#A9AEB1`
- **Tailwind Classes:** `text-neutral`, `bg-neutral`, `border-neutral`
- **Usage:** Structural elements. Used for borders, subtle backgrounds, inactive states, and secondary text. Use darker shades (e.g., `text-neutral-800`) for standard body text.

### Typography
- **Primary Font Family:** `Figtree`, sans-serif
- **Heading Styles:** Clean, readable, with distinct visual hierarchy. Use `font-bold` or `font-semibold` with darker neutral colors or primary green for major headings.
- **Body Text:** Standard weight, highly legible.

## UI Components & Styling Rules

### 1. Buttons
- **Primary Button:** `bg-primary text-white hover:bg-primary-700 focus:ring-primary`
- **Secondary Button:** `bg-secondary text-white hover:bg-secondary-500 focus:ring-secondary`
- **Ghost/Outline Button:** `border-primary text-primary hover:bg-primary-50 focus:ring-primary`

### 2. Layout & Spacing
- Use standard Tailwind utility classes (`p-4`, `m-2`, `flex`, `grid`, `gap-4`, etc.).
- Ensure consistent padding and responsive layout adjustments (e.g., stacked columns on mobile via `flex-col`, side-by-side on desktop via `md:flex-row`).

### 3. Forms & Inputs
- Standard inputs should have subtle borders (`border-neutral-300`).
- Focus states must use brand colors: `focus:border-primary focus:ring-primary`.

### 4. Accessibility & Best Practices
- **Contrast:** Ensure all text passes WCAG contrast ratios. Do not use white text on light backgrounds (e.g., don't use white text on a light secondary gold unless contrast is verified).
- **Interactive Elements:** Ensure all clickable elements (`a`, `button`) have clear `hover` and `focus` states.
- **Clean HTML/CSS:** Avoid writing custom CSS where Tailwind utility classes can achieve the result. Use semantic HTML (e.g., `<nav>`, `<main>`, `<section>`, `<article>`).

## Anti-patterns
- ❌ Do NOT use `indigo`, `purple`, or any other legacy default colors.
- ❌ Do NOT use non-brand gradients.
- ❌ Avoid inline styles. Use Tailwind utilities exclusively.
