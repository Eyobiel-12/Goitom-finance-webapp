# PDF-template Uitleg

## Wat doet de template-selectie?

De template-selectie bepaalt **het visuele ontwerp** van je factuur PDF. Elke template heeft een andere stijl:

### 1. **Modern** (Groen thema, professioneel)
- **Primaire kleur**: Groen (#10b981)
- **Layout**: Ruime marges, subtiele achtergronden
- **Geschikt voor**: Professionele bedrijven, tech companies
- **Karakteristiek**: Modern, clean, futuristisch

### 2. **Minimaal** (Simpel en clean)
- **Primaire kleur**: In stalen grijs/zwarten tinten
- **Layout**: Minimale elementen, veel whitespace
- **Geschikt voor**: Designers, creatieve bureaus
- **Karakteristiek**: Eenvoudig, clean, minimalistisch

### 3. **Klassiek** (Traditionele stijl)
- **Primaire kleur**: Donkerblauw/antraciet
- **Layout**: Traditionele layout met schaduwen
- **Geschikt voor**: Juridische diensten, advocaten, accountants
- **Karakteristiek**: Traditioneel, serieus, betrouwbaar

### 4. **Bold** (Opvallende kleuren)
- **Primaire kleur**: Felrood/oranje/paars
- **Layout**: Dynamische kleuren en bold typografie
- **Geschikt voor**: Marketing agencies, creatieve industrie
- **Karakteristiek**: Opvallend, energiek, creatief

## Huidige Status

⚠️ **Let op**: De template-selector is nu **visueel** en slaagt de keuze op. Er zijn nog geen aparte PDF-templates aangemaakt. Alle facturen gebruiken momenteel hetzelfde "Modern" ontwerp.

## Aanbevolen Stappen

1. Maak 4 verschillende Blade templates in `resources/views/invoices/`:
   - `pdf-modern.blade.php`
   - `pdf-minimal.blade.php`
   - `pdf-classic.blade.php`
   - `pdf-bold.blade.php`

2. Pas de PDF-route aan om het juiste template te laden gebaseerd op `--template` CSS variabele

3. Of: Gebruik PHP om het juiste template bestand te includen:
   ```php
   $template = $invoice->organization->settings['pdf_template'] ?? 'modern';
   return view("invoices.pdf-{$template}", compact('invoice'))->render();
   ```

