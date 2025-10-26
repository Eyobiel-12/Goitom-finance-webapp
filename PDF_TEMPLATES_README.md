# PDF Templates - Goitom Finance

## Overzicht

De PDF template selector op `/app/pdf-settings` geeft gebruikers controle over het visuele ontwerp van hun factuur PDF's.

## Beschikbare Templates

### 1. **Modern** (Standaard)
- **Kleur**: Groen (#10b981)
- **Stijl**: Clean, modern, ruimtelijk
- **Font**: Inter, sans-serif
- **Layout**: Subtiele boxen, ruime marges
- **Geschikt voor**: Tech bedrijven, software development, moderne agencies

### 2. **Minimaal**
- **Kleur**: Zwart/grijs
- **Stijl**: Ultra minimal, veel whitespace
- **Font**: Arial, clean sans-serif
- **Layout**: Geen boxes, alleen lijnen en text
- **Geschikt voor**: Designers, creatieve bureaus, minimalistische merken

### 3. **Klassiek**
- **Kleur**: Blauw (#1e40af)
- **Stijl**: Traditioneel, formeel
- **Font**: Georgia, serif
- **Layout**: Bordered boxes, formele structuur
- **Geschikt voor**: Advocaten, accountants, juridische diensten

### 4. **Bold**
- **Kleur**: Rood (#e63946)
- **Stijl**: Energiek, opvallend, dynamisch
- **Font**: Arial Bold, uppercase
- **Layout**: Gradient headers, grote badges, shadows
- **Geschikt voor**: Marketing agencies, entertainment, creatieve industrie

## Functionaliteit

### Wat werkt:
✅ **Kleur kiezen** → Dynamisch toegepast via CSS variabele `--primary-color`
✅ **Logo uploaden** → Wordt getoond in de header
✅ **Tagline aanpassen** → Verschijnt onder bedrijfsnaam
✅ **Footer message** → Onderaan factuur
✅ **Template selecteren** → Laadt het juiste Blade bestand

### Template Files:
- `resources/views/invoices/pdf-modern.blade.php` - Modern template
- `resources/views/invoices/pdf-minimal.blade.php` - Minimal template
- `resources/views/invoices/pdf-classic.blade.php` - Classic template
- `resources/views/invoices/pdf-bold.blade.php` - Bold template

### Database Fields:
```php
// In organization->settings JSON:
{
    'pdf_template': 'modern|minimal|classic|bold',
    'pdf_primary_color': '#10b981',
    'pdf_show_logo': true/false,
    'pdf_footer_message': 'Bedankt voor je vertrouwen!'
}

// In organizations table:
- logo_path: string (e.g. 'logos/abc123.jpg')
- tagline: string (e.g. 'Professionele Financiële Diensten')
```

## Gebruik

1. Ga naar `/app/pdf-settings`
2. Selecteer een template (Modern/Minimal/Classic/Bold)
3. Kies een kleur met de color picker
4. Upload optioneel een logo
5. Vul tagline en footer message in
6. Klik "Instellingen opslaan"
7. Genereer een factuur PDF → Het geselecteerde template wordt gebruikt

## Technische Implementatie

```php
// In routes/web.php:
$template = $invoice->organization->settings['pdf_template'] ?? 'modern';
$viewName = "invoices.pdf-{$template}";
$pdf = \PDF::loadView($viewName, compact('invoice'));
```

## Customization

Elk template kan aangepast worden door:
- CSS styles te wijzigen in de `<style>` sectie
- HTML structuur aan te passen
- Extra features toe te voegen (bijv. barcode, QR code)

**Let op**: Wijzigingen worden direct toegepast bij volgende PDF generatie.

