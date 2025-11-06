# BTW Aangifte System Analysis & Enhancement Plan

## 📊 Current System Analysis

### ✅ **What's Working Well**

1. **Basic Structure**: BTW Aangifte model with calculate() method
2. **BTW Aftrek System**: Deduction tracking for expenses
3. **Quarterly/Annual Support**: Flexible filing periods
4. **Status Tracking**: Concept → Ingediend workflow
5. **Auto-Calculation**: Automatic calculation from invoices and expenses

---

## ⚠️ **Critical Issues vs. Belastingdienst Requirements**

### 1. **Invoice Date Logic - INCORRECT** ⚠️
**Current**: Uses `issue_date` for BTW calculation
**Belastingdienst Requirement**: 
- For **factuurstelsel** (invoice basis): Use factuurdatum (invoice date)
- For **kassastelsel** (cash basis): Use ontvangstdatum (payment received date)
- Your system calculates only from **paid invoices**, which suggests cash basis but uses invoice dates

**Impact**: May calculate BTW in wrong period → Incorrect filing → Penalties

### 2. **Missing BTW Percentage Breakdown** ⚠️
**Belastingdienst Requires**:
- BTW 0% (exports, intra-EU)
- BTW 9% (food, books, medicine)
- BTW 21% (standard rate)

**Current**: No percentage tracking - assumes single rate

### 3. **No Deadline Tracking** ⚠️
**Missing**:
- Automatic deadline calculation (last day of month following quarter)
- Reminders/alerts before deadline
- Late filing penalties calculation

### 4. **No PDF Export for Filing** ⚠️
**Required**: Printable format matching Belastingdienst forms

### 5. **Missing Validations** ⚠️
- No check for missing required fields
- No validation of BTW numbers
- No duplicate filing prevention

### 6. **No Correction Mechanism** ⚠️
**New Rule 2025**: Corrections must be filed within 8 weeks of discovery

### 7. **Missing Special Regimes** ⚠️
- **KOR** (Kleine Ondernemers Regeling): No BTW for < €20,000 turnover
- **Reverse Charge**: For services to foreign clients
- **ICP** (Intra-Communautaire Prestatie): EU transactions tracking

---

## 🚀 **Enhancement Roadmap**

### **Phase 1: Critical Fixes (Priority 1)**

#### 1.1 Fix Date Logic
```php
// Add to Organization model
- 'btw_stelsel' => 'factuur' | 'kassa' (invoice or cash basis)

// Update BtwAangifte::calculate()
- If kassastelsel: Use payment_date from invoices
- If factuurstelsel: Use issue_date
```

#### 1.2 Add BTW Percentage Tracking
```php
// Invoice Items table needs:
- vat_percentage (0, 9, 21)

// BtwAangifte calculation should break down:
- ontvangen_btw_0 (0% BTW received)
- ontvangen_btw_9 (9% BTW received)  
- ontvangen_btw_21 (21% BTW received)
```

#### 1.3 Add Deadline Tracking
```php
// Migration: Add to btw_aangifte table
- deadline (date)
- is_overdue (boolean)
- late_filing_penalty (decimal)

// Logic:
- Q1 (Jan-Mar) → Deadline: April 30
- Q2 (Apr-Jun) → Deadline: July 31
- Q3 (Jul-Sep) → Deadline: October 31
- Q4 (Oct-Dec) → Deadline: January 31 (next year)
```

---

### **Phase 2: Core Functionality (Priority 2)**

#### 2.1 PDF Export for Filing
- Generate official-looking PDF matching Belastingdienst format
- Include all required fields
- Printable format

#### 2.2 Correction System
```php
// New table: btw_aangifte_correcties
- original_aangifte_id
- correction_reason
- discovered_date
- filed_within_8_weeks (boolean)
```

#### 2.3 Validation System
- Pre-submit validation checks
- BTW number format validation (NLXXXXXXXXB01)
- Duplicate filing prevention
- Missing data warnings

#### 2.4 Dashboard & Alerts
- Upcoming deadlines widget
- Overdue filing alerts
- Filing status overview
- Quick actions (create, submit, correct)

---

### **Phase 3: Advanced Features (Priority 3)**

#### 3.1 KOR (Kleine Ondernemers Regeling) Support
```php
// Organization settings:
- kor_eligible (boolean)
- kor_turnover_limit (20000)
- kor_exemption (boolean)

// Logic: If KOR eligible and turnover < limit:
- Set all BTW to 0
- Mark as "KOR vrijgesteld"
```

#### 3.2 Reverse Charge Mechanism
```php
// For B2B international services:
- invoice->reverse_charge (boolean)
- BTW not charged to client
- BTW declared but no payment
```

#### 3.3 ICP (Intra-EU) Tracking
```php
// New table: btw_icp_transactions
- client_country
- service_type
- amount
- period

// Quarterly ICP submission required
```

#### 3.4 Belastingdienst API Integration
- OAuth2 with eHerkenning
- Direct submission via API
- Real-time status updates
- Automatic receipt confirmation

---

### **Phase 4: User Experience (Priority 4)**

#### 4.1 Enhanced UI
- Modern filing wizard
- Step-by-step guidance
- Visual timeline of deadlines
- Color-coded status indicators

#### 4.2 Reports & Analytics
- Year-over-year comparison
- BTW trends analysis
- Expense breakdown by category
- Tax optimization insights

#### 4.3 Mobile Optimization
- Mobile-friendly filing interface
- Deadline reminders via push notifications
- Quick filing from mobile

#### 4.4 Multi-language Support
- Dutch (primary)
- English (secondary)

---

## 📋 **Database Schema Enhancements**

### **New Fields for btw_aangifte**
```sql
ALTER TABLE btw_aangifte ADD COLUMN:
- deadline DATE
- is_overdue BOOLEAN DEFAULT FALSE
- late_filing_penalty DECIMAL(10,2) DEFAULT 0
- correction_of_id BIGINT NULL
- correction_reason TEXT NULL
- filed_via ENUM('manual', 'api') DEFAULT 'manual'
- belastingdienst_reference VARCHAR(255) NULL
- ontvangen_btw_0 DECIMAL(15,2) DEFAULT 0
- ontvangen_btw_9 DECIMAL(15,2) DEFAULT 0  
- ontvangen_btw_21 DECIMAL(15,2) DEFAULT 0
- betaalde_btw_0 DECIMAL(15,2) DEFAULT 0
- betaalde_btw_9 DECIMAL(15,2) DEFAULT 0
- betaalde_btw_21 DECIMAL(15,2) DEFAULT 0
```

### **New Table: btw_settings**
```sql
CREATE TABLE btw_settings (
    organization_id BIGINT PRIMARY KEY,
    btw_stelsel ENUM('factuur', 'kassa') DEFAULT 'factuur',
    kor_eligible BOOLEAN DEFAULT FALSE,
    kor_turnover_limit DECIMAL(10,2) DEFAULT 20000,
    kor_exemption BOOLEAN DEFAULT FALSE,
    filing_frequency ENUM('monthly', 'quarterly', 'annual') DEFAULT 'quarterly',
    reminder_days_before_deadline INT DEFAULT 7,
    auto_submit BOOLEAN DEFAULT FALSE
);
```

---

## 🎯 **Immediate Action Items**

1. **URGENT**: Fix date logic (issue_date vs payment_date)
2. **URGENT**: Add BTW percentage breakdown (0%, 9%, 21%)
3. **HIGH**: Implement deadline tracking
4. **HIGH**: Add validation checks
5. **MEDIUM**: Create PDF export
6. **MEDIUM**: Build correction system

---

## 📚 **Resources & Compliance**

### **Official Belastingdienst Resources**
- [Mijn Belastingdienst Zakelijk](https://www.belastingdienst.nl/zakelijk/btw/)
- [BTW Aangifte Handleiding](https://www.belastingdienst.nl/wps/wcm/connect/bldcontentnl/belastingdienst/zakelijk/btw/btw_aangifte/)
- [API Documentation](https://developers.belastingdienst.nl/)

### **Key Deadlines**
- Q1: January 31
- Q2: April 30  
- Q3: July 31
- Q4: October 31
- Annual: March 31 (next year)

---

## 💡 **Additional Recommendations**

1. **Audit Trail**: Log all changes to BTW filings
2. **Backup System**: Automatic export before submission
3. **Integration**: Connect with accounting software (Exact, AFAS, etc.)
4. **Notifications**: Email/SMS reminders before deadlines
5. **Expert Review**: Periodic review by tax advisor functionality

---

## 📊 **Testing Checklist**

- [ ] Test with cash basis accounting
- [ ] Test with invoice basis accounting  
- [ ] Test with different BTW percentages (0%, 9%, 21%)
- [ ] Test deadline calculations
- [ ] Test correction workflow
- [ ] Test validation rules
- [ ] Test PDF export format
- [ ] Test KOR exemption
- [ ] Test reverse charge scenarios

---

**Last Updated**: 2025-01-03
**Priority Level**: 🔴 CRITICAL - Compliance issues detected

