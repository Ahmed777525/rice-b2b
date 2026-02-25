# 🧪 Testing Guide - Rice B2B Platform

## Test Environment
- **URL**: http://rice-b2b.test (or http://localhost:8000)
- **PHP Version**: 8.3.26
- **Laravel Version**: 12
- **Database**: MySQL (rice_b2b)

---

## Phase 1: Authentication Tests

### 1.1 User Registration
- [ ] Test Trader Registration with valid data
- [ ] Test Trader Registration with invalid data (missing fields)
- [ ] Test Trader Registration with duplicate email
- [ ] Test Trader Registration without commercial record

### 1.2 User Login
- [ ] Test Login with correct credentials
- [ ] Test Login with incorrect password
- [ ] Test Login with non-existent email
- [ ] Test Logout functionality

### 1.3 Password Reset
- [ ] Test password reset request
- [ ] Test password reset with invalid token

---

## Phase 2: Localization Tests

### 2.1 Language Switching
- [ ] Switch to Arabic (RTL direction)
- [ ] Switch to English (LTR direction)
- [ ] Verify all UI elements translate correctly
- [ ] Verify layout direction changes properly

---

## Phase 3: Product & Inventory Tests

### 3.1 Product Listing (Public)
- [ ] View all products without login (should show prices as hidden)
- [ ] View product details without login

### 3.2 Product Listing (Authenticated)
- [ ] View products after login (should show prices)
- [ ] View product details with prices
- [ ] Filter products by category

### 3.3 Inventory Management
- [ ] Check stock levels per branch
- [ ] Test low stock alert (when quantity ≤ 10)
- [ ] Verify stock is branch-specific

---

## Phase 4: Cart & Checkout Tests

### 4.1 Shopping Cart
- [ ] Add product to cart (authenticated)
- [ ] Update product quantity in cart
- [ ] Remove product from cart
- [ ] Clear entire cart
- [ ] Cart persists between sessions
- [ ] Cart reserves stock (pending status)

### 4.2 Checkout Process
- [ ] Proceed to checkout with items in cart
- [ ] Select payment method (Visa/Mada/PayPal)
- [ ] Complete checkout (sandbox mode)
- [ ] Order is created with "pending" status
- [ ] Verify order number is generated

---

## Phase 5: Order Management Tests

### 5.1 Trader Orders
- [ ] View own orders list
- [ ] View order details
- [ ] Cancel order (if allowed)
- [ ] Download invoice

### 5.2 Admin/Manager Orders
- [ ] View all orders in dashboard
- [ ] Filter orders by status
- [ ] Filter orders by branch
- [ ] Search orders by order number or customer

### 5.3 Order Approval Workflow
- [ ] **Approve Order**: 
  - Order status changes from "pending" to "approved"
  - Stock is deducted from inventory
- [ ] **Reject Order**:
  - Order status changes to "rejected"
  - Reserved stock is released
- [ ] **Update Status**:
  - approved → processing → shipped → completed
  - Verify status transitions are valid

---

## Phase 6: Payment Tests

### 6.1 Sandbox Payment
- [ ] Test Visa payment in sandbox mode
- [ ] Test Mada payment in sandbox mode
- [ ] Test PayPal payment in sandbox mode
- [ ] Verify callback handling
- [ ] Verify order status updates after payment

### 6.2 Payment Security
- [ ] Verify SSL is enabled
- [ ] Verify payment data is encrypted
- [ ] Test webhook verification

---

## Phase 7: Admin Panel Tests

### 7.1 Dashboard
- [ ] View today's orders count
- [ ] View today's revenue
- [ ] View monthly statistics
- [ ] View pending approvals count
- [ ] View recent orders
- [ ] View low stock alerts

### 7.2 Order Management
- [ ] List all orders with pagination
- [ ] View order details
- [ ] Approve pending order
- [ ] Reject order with reason
- [ ] Update order status
- [ ] Export orders to CSV

### 7.3 Branch Management
- [ ] List all branches
- [ ] Create new branch
- [ ] Edit branch details
- [ ] Assign manager to branch
- [ ] Deactivate branch

---

## Phase 8: Multi-Tenancy Readiness Tests

### 8.1 Tenant Isolation
- [ ] Verify users can only see their company's data
- [ ] Verify orders are branch-specific
- [ ] Verify stock is branch-specific

### 8.2 Future Multi-Tenancy Features
- [ ] System is ready for tenant_id column addition
- [ ] Relationships are properly structured for multi-tenancy

---

## Test Accounts

| Role | Email | Password | Branch |
|------|-------|----------|--------|
| Admin | admin@riceb2b.com | password | All |
| Branch Manager | manager@riceb2b.com | password | Riyadh |
| Branch Manager | jeddah@riceb2b.com | password | Jeddah |
| Trader | trader1@riceb2b.com | password | Riyadh |
| Trader | trader2@riceb2b.com | password | Jeddah |

---

## Expected Results Summary

### Registration Flow
1. User registers → Account created → Auto-login → Redirected to dashboard

### Shopping Flow
1. Login → Browse products → Add to cart → Checkout → Payment → Order created (pending)
2. Manager approves → Stock deducted → Status: approved
3. Order processed → Shipped → Completed

### Admin Flow
1. Login as Admin/Manager → Dashboard → View stats
2. Navigate to Orders → Approve/Reject → Update status
3. Navigate to Branches → Manage branches

---

## Bug Reporting Template

```
Title: [Brief Description]
Environment: [Browser, OS]
Steps to Reproduce:
1. 
2. 
3. 
Expected Behavior: 
Actual Behavior: 
Severity: [Critical/High/Medium/Low]
```

---

## Performance Benchmarks

- Page load time: < 2 seconds
- Database queries per request: < 10
- API response time: < 500ms
