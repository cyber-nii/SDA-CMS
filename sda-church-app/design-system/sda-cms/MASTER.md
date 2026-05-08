# Design System Master File

> **LOGIC:** When building a specific page, first check `design-system/pages/[page-name].md`.
> If that file exists, its rules **override** this Master file.
> If not, strictly follow the rules below.

---

**Project:** SDA CMS
**Updated:** 2026-05-02
**Category:** Church/Religious Organization — Seventh-day Adventist

---

## Global Rules

### Color Palette

| Role | Hex | Tailwind Token |
|------|-----|----------------|
| Primary (SDA Green) | `#2E5F3B` | `primary-600` |
| Primary Light | `#5c9676` | `primary-400` |
| Secondary (SDA Gold) | `#E3A82B` | `secondary-400` |
| Neutral (SDA Gray) | `#A9AEB1` | `neutral-400` |
| Background | `#F8FAFC` | `neutral-50` |
| Surface (cards) | `#FFFFFF` | `white` |
| Text Primary | `#0f172a` | `gray-900` |
| Text Muted | `#64748b` | `gray-500` |

**Color Notes:** SDA Brand — Deep Green (trust, growth) + Gold (warmth, value) on light neutral base.

**60-30-10 Rule:**
- 60% → `neutral-50` / `white` backgrounds
- 30% → `primary-*` green (nav accents, icons, active states)
- 10% → `secondary-400` gold (CTAs, highlights, accents)

---

### Typography

- **Heading Font:** Playfair Display (landing/marketing pages)
- **Body Font:** Figtree (all app screens via `fonts.bunny.net`)
- **Mood:** trustworthy, professional, community-oriented

**CSS Imports:**
```css
/* App screens (via Vite) */
@import url('https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap');

/* Marketing/landing pages only */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap');
```

---

### Spacing (8-Point Grid)

| Token | Value | Usage |
|-------|-------|-------|
| `--space-xs` | `4px` | Tight gaps |
| `--space-sm` | `8px` | Icon gaps, inline spacing |
| `--space-md` | `16px` | Standard padding |
| `--space-lg` | `24px` | Section padding |
| `--space-xl` | `32px` | Large gaps |
| `--space-2xl` | `48px` | Section margins |
| `--space-3xl` | `64px` | Hero padding |

---

### Shadow Depths

| Level | Value | Usage |
|-------|-------|-------|
| `shadow-sm` | `0 1px 2px rgba(0,0,0,0.05)` | Subtle lift (nav, dividers) |
| `shadow-md` | `0 4px 6px rgba(0,0,0,0.1)` | Cards, form panels |
| `shadow-lg` | `0 10px 15px rgba(0,0,0,0.1)` | Modals, dropdowns |
| `shadow-xl` | `0 20px 25px rgba(0,0,0,0.15)` | Hero images, featured cards |

---

## Component Specs

### Buttons

```css
/* Primary Button — SDA Green */
.btn-primary {
  background: linear-gradient(135deg, #2E5F3B 0%, #407b5a 100%);
  color: white;
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 600;
  box-shadow: 0 2px 8px rgba(46,95,59,0.35);
  transition: transform 200ms ease, box-shadow 200ms ease;
}
.btn-primary:hover {
  transform: translateY(-1px);
  box-shadow: 0 6px 20px rgba(46,95,59,0.4);
}

/* Secondary Button */
.btn-secondary {
  background: transparent;
  color: #2E5F3B;
  border: 2px solid #2E5F3B;
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 600;
  transition: all 200ms ease;
}
```

### Cards

```css
.card {
  background: white;
  border-radius: 12px;
  padding: 24px;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 2px rgba(0,0,0,0.05);
  transition: all 200ms ease;
}
.card:hover {
  border-color: #83b499; /* primary-300 */
  box-shadow: 0 8px 24px rgba(46,95,59,0.1);
  transform: translateY(-2px);
}
```

### Inputs

```css
.input {
  padding: 12px 16px;
  border: 1px solid #E2E8F0;
  border-radius: 8px;
  font-size: 16px;
  transition: border-color 200ms ease;
}
.input:focus {
  border-color: #2E5F3B;
  outline: none;
  box-shadow: 0 0 0 3px rgba(46,95,59,0.15);
}
```

---

## Style Guidelines

**Style:** Accessible & Trustworthy

**Keywords:** High contrast, large text (16px+), keyboard navigation, screen reader friendly, WCAG 2.1 AA compliant, visible focus states, semantic HTML

**Key Effects:**
- Focus rings: `ring-2 ring-primary-400 ring-offset-1`
- Touch targets: minimum 44×44px
- ARIA labels on all icon-only buttons
- `prefers-reduced-motion` respected

### Page Pattern

**Pattern Name:** Hero-Centric + Feature Strip

- **CTA Placement:** Above fold
- **Section Order:** Hero → Feature Cards → Footer

---

## Navigation Rules

- Nav background: `bg-white` with `border-b-2 border-b-primary-500` accent
- Active links use `border-b-2 border-primary-500 text-primary-600`
- Max 5 top-level items — group secondary items into "Records" dropdown
- User avatar: deterministic color from name, NOT purple/violet

---

## Anti-Patterns (Do NOT Use)

- ❌ **Purple / Violet / Indigo** — banned from this project entirely
- ❌ **Emojis as icons** — use SVG icons (Heroicons/Lucide)
- ❌ **Missing `cursor:pointer`** — all clickable elements must have it
- ❌ **Layout-shifting hovers** — no scale transforms that shift layout
- ❌ **Low contrast text** — maintain 4.5:1 minimum
- ❌ **Instant state changes** — always use transitions (150-300ms)
- ❌ **Invisible focus states** — must be visible for a11y
- ❌ **`h2`/`h3` as card labels** — use `p` or `span` for non-heading text
- ❌ **Inline `style=""` attributes** — use Tailwind utilities or CSS classes
- ❌ **Blue/pink gender stereotypes** — use brand colors for data charts

---

## Pre-Delivery Checklist

- [ ] No purple/violet/indigo anywhere
- [ ] All icons from consistent SVG set (Heroicons/Lucide)
- [ ] `cursor-pointer` on all clickable elements
- [ ] Hover states with smooth transitions (150-300ms)
- [ ] Light mode text contrast 4.5:1 minimum
- [ ] Focus states visible for keyboard navigation
- [ ] `prefers-reduced-motion` respected
- [ ] Responsive: 375px, 768px, 1024px, 1440px
- [ ] No content hidden behind fixed navbars
- [ ] No horizontal scroll on mobile
- [ ] Heading hierarchy correct (`h1` > `h2` > `h3`, no skips)
