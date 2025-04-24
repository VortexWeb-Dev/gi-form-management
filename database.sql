-- DROP TABLES IF EXIST (for clean re-run)
DROP TABLE IF EXISTS notifications, audit_logs, digital_signatures, form_responses, form_assignments, form_fields, form_templates, hr_config;

-- 1. form_templates
CREATE TABLE form_templates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    file_path VARCHAR(255),
    created_by INT,
    created_at DATETIME,
    updated_at DATETIME,
    is_active BOOLEAN
);

-- 2. form_fields
CREATE TABLE form_fields (
    id INT AUTO_INCREMENT PRIMARY KEY,
    template_id INT,
    label VARCHAR(255),
    type VARCHAR(50),
    is_required BOOLEAN,
    field_order INT,
    placeholder VARCHAR(255),
    FOREIGN KEY (template_id) REFERENCES form_templates(id)
);

-- 3. form_assignments
CREATE TABLE form_assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    template_id INT,
    assigned_to INT,
    assigned_by INT,
    status ENUM('pending', 'submitted', 'approved', 'rejected'),
    assigned_at DATETIME,
    submitted_at DATETIME,
    reviewed_at DATETIME,
    remarks TEXT,
    FOREIGN KEY (template_id) REFERENCES form_templates(id)
);

-- 4. form_responses
CREATE TABLE form_responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    assignment_id INT,
    field_id INT,
    response_value TEXT,
    FOREIGN KEY (assignment_id) REFERENCES form_assignments(id),
    FOREIGN KEY (field_id) REFERENCES form_fields(id)
);

-- 5. digital_signatures
CREATE TABLE digital_signatures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    assignment_id INT,
    signed_by INT,
    signed_at DATETIME,
    method ENUM('drawn', 'typed', 'stored'),
    signature_data TEXT,
    FOREIGN KEY (assignment_id) REFERENCES form_assignments(id)
);

-- 6. audit_logs
CREATE TABLE audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    action VARCHAR(100),
    user_id INT,
    target_id INT,
    context VARCHAR(50),
    details TEXT,
    timestamp DATETIME
);

-- 7. notifications
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    assignment_id INT,
    type ENUM('assigned', 'submitted', 'reminder', 'reviewed', 'approved', 'rejected'),
    message TEXT,
    is_read BOOLEAN,
    created_at DATETIME,
    FOREIGN KEY (assignment_id) REFERENCES form_assignments(id)
);

-- 8. hr_config
CREATE TABLE hr_config (
    id INT AUTO_INCREMENT PRIMARY KEY,
    config_key VARCHAR(100),
    value TEXT
);

-- DUMMY DATA INSERTS
-- --------------------------------------------------------

--
-- Table structure for table `form_templates`
--

INSERT INTO `form_templates` (`id`, `title`, `description`, `file_path`, `created_by`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'Employee Onboarding', 'Comprehensive form for onboarding new real estate agents and staff', '/templates/onboarding.pdf', 1938, '2025-01-15 09:30:00', '2025-03-22 14:15:00', 1),
(2, 'Exit Interview', 'Exit interview form for departing employees', '/templates/exit_interview.pdf', 1938, '2025-01-16 10:45:00', '2025-02-28 11:20:00', 1),
(3, 'Performance Review', 'Quarterly performance evaluation for real estate agents', '/templates/performance_review.pdf', 1938, '2025-01-20 14:30:00', '2025-04-10 16:45:00', 1),
(4, 'Property Showing Feedback', 'Form for agents to document client feedback after property showings', '/templates/showing_feedback.pdf', 1938, '2025-02-05 11:15:00', '2025-03-15 09:30:00', 1),
(5, 'Commission Structure Acknowledgment', 'Form for agents to acknowledge commission structure changes', '/templates/commission_ack.pdf', 1938, '2025-03-01 15:30:00', '2025-03-01 15:30:00', 1),
(6, 'Training Request', 'Form for requesting additional training or certification courses', '/templates/training_request.pdf', 1938, '2025-03-10 13:45:00', '2025-04-05 10:20:00', 1),
(7, 'Expense Reimbursement', 'Form for submitting business expenses for reimbursement', '/templates/expense_reimburse.pdf', 1938, '2025-02-15 09:15:00', '2025-04-12 11:30:00', 1),
(8, 'Equipment Request', 'Request form for office equipment and technology', '/templates/equipment_request.pdf', 1938, '2025-02-18 14:20:00', '2025-03-25 16:10:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `form_fields`
--

INSERT INTO `form_fields` (`id`, `template_id`, `label`, `type`, `is_required`, `field_order`, `placeholder`) VALUES
-- Employee Onboarding Form Fields
(1, 1, 'Full Name', 'text', 1, 1, 'Enter your full legal name'),
(2, 1, 'Date of Joining', 'date', 1, 2, ''),
(3, 1, 'Position', 'select', 1, 3, 'Select your position'),
(4, 1, 'Department', 'select', 1, 4, 'Select your department'),
(5, 1, 'License Number', 'text', 0, 5, 'Real estate license number (if applicable)'),
(6, 1, 'Emergency Contact', 'text', 1, 6, 'Name and phone number'),
(7, 1, 'Residential Address', 'textarea', 1, 7, 'Your current residential address'),
(8, 1, 'Banking Information', 'textarea', 1, 8, 'For direct deposit of commissions'),

-- Exit Interview Form Fields
(9, 2, 'Reason for Leaving', 'select', 1, 1, 'Select primary reason'),
(10, 2, 'Last Working Day', 'date', 1, 2, ''),
(11, 2, 'Feedback on Management', 'textarea', 1, 3, 'Please provide honest feedback'),
(12, 2, 'Feedback on Work Environment', 'textarea', 1, 4, 'Your experience with the work environment'),
(13, 2, 'Suggestions for Improvement', 'textarea', 0, 5, 'Any suggestions for the company'),
(14, 2, 'Return Interview', 'checkbox', 0, 6, 'Would you consider returning to our company in the future?'),

-- Performance Review Form Fields
(15, 3, 'Review Period', 'text', 1, 1, 'e.g., Q1 2025'),
(16, 3, 'Properties Listed', 'number', 1, 2, 'Number of properties listed this quarter'),
(17, 3, 'Properties Sold', 'number', 1, 3, 'Number of properties sold this quarter'),
(18, 3, 'Revenue Generated', 'currency', 1, 4, 'Total sales volume in dollars'),
(19, 3, 'Client Satisfaction Score', 'number', 0, 5, 'Average client satisfaction rating (1-10)'),
(20, 3, 'Goals for Next Quarter', 'textarea', 1, 6, 'List your goals for the next quarter'),
(21, 3, 'Professional Development', 'textarea', 0, 7, 'Areas you want to develop'),

-- Property Showing Feedback Form Fields
(22, 4, 'Property Address', 'text', 1, 1, 'Full property address'),
(23, 4, 'Showing Date', 'date', 1, 2, ''),
(24, 4, 'Client Name', 'text', 1, 3, 'Name of potential buyer'),
(25, 4, 'Client Interest Level', 'select', 1, 4, 'Select interest level (1-5)'),
(26, 4, 'Property Feedback', 'textarea', 1, 5, 'Client\'s feedback on the property'),
(27, 4, 'Price Feedback', 'textarea', 1, 6, 'Client\'s thoughts on pricing'),
(28, 4, 'Follow-up Required', 'checkbox', 1, 7, 'Does this client require follow-up?'),

-- Commission Structure Acknowledgment Form Fields
(29, 5, 'Effective Date', 'date', 1, 1, ''),
(30, 5, 'Previous Commission Rate', 'percentage', 1, 2, 'Your previous commission rate'),
(31, 5, 'New Commission Rate', 'percentage', 1, 3, 'Your new commission rate'),
(32, 5, 'Acknowledgment', 'checkbox', 1, 4, 'I acknowledge and accept the new commission structure'),

-- Training Request Form Fields
(33, 6, 'Training Course Name', 'text', 1, 1, 'Enter course name'),
(34, 6, 'Training Provider', 'text', 1, 2, 'Name of training provider'),
(35, 6, 'Course Date', 'date', 1, 3, ''),
(36, 6, 'Course Cost', 'currency', 1, 4, 'Cost in dollars'),
(37, 6, 'Business Justification', 'textarea', 1, 5, 'How will this benefit your role and the company?'),
(38, 6, 'Manager Approval', 'checkbox', 0, 6, 'Manager has verbally approved'),

-- Expense Reimbursement Form Fields
(39, 7, 'Expense Date', 'date', 1, 1, ''),
(40, 7, 'Expense Category', 'select', 1, 2, 'Select expense category'),
(41, 7, 'Amount', 'currency', 1, 3, 'Amount in dollars'),
(42, 7, 'Receipt Attached', 'file', 1, 4, ''),
(43, 7, 'Expense Description', 'textarea', 1, 5, 'Detailed description of business expense'),
(44, 7, 'Client Related', 'checkbox', 0, 6, 'Is this expense related to a specific client?'),
(45, 7, 'Client Name', 'text', 0, 7, 'If client-related, enter client name'),

-- Equipment Request Form Fields
(46, 8, 'Equipment Type', 'select', 1, 1, 'Select equipment type'),
(47, 8, 'Equipment Description', 'text', 1, 2, 'Specific details of requested equipment'),
(48, 8, 'Business Justification', 'textarea', 1, 3, 'Why this equipment is needed'),
(49, 8, 'Urgency Level', 'select', 1, 4, 'Select urgency level'),
(50, 8, 'Estimated Cost', 'currency', 0, 5, 'If known');

-- --------------------------------------------------------

--
-- Table structure for table `form_assignments`
--

INSERT INTO `form_assignments` (`id`, `template_id`, `assigned_to`, `assigned_by`, `status`, `assigned_at`, `submitted_at`, `reviewed_at`, `remarks`) VALUES
-- Employee Onboarding assignments
(1, 1, 1945, 1938, 'approved', '2025-02-10 09:15:00', '2025-02-12 14:30:00', '2025-02-13 10:45:00', 'All documentation complete and properly filled.'),
(2, 1, 1636, 1938, 'approved', '2025-01-05 11:20:00', '2025-01-07 16:45:00', '2025-01-08 09:30:00', 'Welcome to the team!'),
(3, 1, 1956, 1938, 'pending', '2025-04-22 13:30:00', NULL, NULL, 'Please complete onboarding forms by end of week'),

-- Exit Interview assignments
(4, 2, 1635, 1938, 'submitted', '2025-03-15 14:45:00', '2025-03-20 15:30:00', NULL, NULL),
(5, 2, 1888, 1938, 'approved', '2025-02-28 16:20:00', '2025-03-05 11:15:00', '2025-03-06 14:30:00', 'We appreciate your feedback and wish you well in your future endeavors.'),

-- Performance Review assignments
(6, 3, 1945, 1938, 'submitted', '2025-04-01 10:30:00', '2025-04-05 16:45:00', NULL, NULL),
(7, 3, 1636, 1938, 'approved', '2025-04-01 10:35:00', '2025-04-03 15:20:00', '2025-04-04 11:45:00', 'Excellent performance this quarter. Keep up the good work!'),
(8, 3, 1956, 1938, 'pending', '2025-04-01 10:40:00', NULL, NULL, 'Due by April 25'),
(9, 3, 1888, 1938, 'rejected', '2025-04-01 10:45:00', '2025-04-06 09:15:00', '2025-04-07 14:30:00', 'Please provide more details on client acquisition strategies'),

-- Property Showing Feedback assignments
(10, 4, 1945, 1938, 'approved', '2025-03-10 13:15:00', '2025-03-10 17:45:00', '2025-03-11 09:30:00', 'Great detailed feedback'),
(11, 4, 1636, 1938, 'approved', '2025-03-12 14:20:00', '2025-03-12 18:30:00', '2025-03-13 10:45:00', 'Follow up with client scheduled'),
(12, 4, 1956, 1938, 'submitted', '2025-04-15 09:45:00', '2025-04-15 16:30:00', NULL, NULL),
(13, 4, 1945, 1938, 'pending', '2025-04-23 15:20:00', NULL, NULL, 'Please complete by end of day'),

-- Commission Structure assignments
(14, 5, 1945, 1938, 'approved', '2025-03-01 10:15:00', '2025-03-02 14:30:00', '2025-03-03 09:45:00', 'Acknowledged new commission structure'),
(15, 5, 1636, 1938, 'approved', '2025-03-01 10:20:00', '2025-03-03 16:15:00', '2025-03-04 11:30:00', 'Acknowledged new commission structure'),
(16, 5, 1956, 1938, 'approved', '2025-03-01 10:25:00', '2025-03-02 09:45:00', '2025-03-03 14:20:00', 'Acknowledged new commission structure'),
(17, 5, 1888, 1938, 'pending', '2025-03-01 10:30:00', NULL, NULL, 'Please acknowledge new commission structure ASAP'),

-- Training Request assignments
(18, 6, 1945, 1938, 'approved', '2025-02-20 13:45:00', '2025-02-21 16:30:00', '2025-02-22 10:15:00', 'Training approved. Please coordinate with Finance for payment.'),
(19, 6, 1636, 1938, 'rejected', '2025-03-05 11:20:00', '2025-03-06 14:45:00', '2025-03-07 09:30:00', 'Budget constraints - please resubmit for next quarter'),
(20, 6, 1956, 1938, 'submitted', '2025-04-10 15:30:00', '2025-04-12 11:45:00', NULL, NULL),

-- Expense Reimbursement assignments
(21, 7, 1945, 1938, 'approved', '2025-03-25 14:15:00', '2025-03-26 16:30:00', '2025-03-27 10:45:00', 'Reimbursement approved. Payment will be processed in next payroll.'),
(22, 7, 1636, 1938, 'approved', '2025-04-05 11:30:00', '2025-04-06 14:45:00', '2025-04-07 09:30:00', 'Approved for payment'),
(23, 7, 1956, 1938, 'submitted', '2025-04-18 15:20:00', '2025-04-19 10:30:00', NULL, NULL),
(24, 7, 1888, 1938, 'pending', '2025-04-22 13:45:00', NULL, NULL, 'Please submit with receipts'),

-- Equipment Request assignments
(25, 8, 1945, 1938, 'approved', '2025-03-15 10:15:00', '2025-03-16 14:30:00', '2025-03-17 09:45:00', 'Equipment ordered. ETA 1 week.'),
(26, 8, 1636, 1938, 'rejected', '2025-03-20 11:30:00', '2025-03-21 16:45:00', '2025-03-22 10:30:00', 'Please use existing equipment. Will reassess next quarter.'),
(27, 8, 1956, 1938, 'pending', '2025-04-23 15:30:00', NULL, NULL, 'Please complete request with more details on necessity');

-- --------------------------------------------------------

--
-- Table structure for table `form_responses`
--

INSERT INTO `form_responses` (`id`, `assignment_id`, `field_id`, `response_value`) VALUES
-- Onboarding responses for employee 1945
(1, 1, 1, 'Michael Johnson'),
(2, 1, 2, '2025-02-15'),
(3, 1, 3, 'Senior Real Estate Agent'),
(4, 1, 4, 'Residential Sales'),
(5, 1, 5, 'REA-78912-CA'),
(6, 1, 6, 'Sarah Johnson, 555-123-4567'),
(7, 1, 7, '123 Oak Avenue, Suite 4B, Los Angeles, CA 90001'),
(8, 1, 8, 'Bank of America, Account #XXXX1234, Routing #XXXX5678'),

-- Onboarding responses for employee 1636
(9, 2, 1, 'Jessica Martinez'),
(10, 2, 2, '2025-01-10'),
(11, 2, 3, 'Real Estate Agent'),
(12, 2, 4, 'Commercial Leasing'),
(13, 2, 5, 'REA-65432-CA'),
(14, 2, 6, 'Robert Martinez, 555-987-6543'),
(15, 2, 7, '456 Pine Street, Apt 7C, San Francisco, CA 94110'),
(16, 2, 8, 'Wells Fargo, Account #XXXX5678, Routing #XXXX8765'),

-- Exit Interview responses for employee 1635
(17, 4, 9, 'Career advancement elsewhere'),
(18, 4, 10, '2025-04-15'),
(19, 4, 11, 'Management was supportive but could improve on communication regarding company goals and direction.'),
(20, 4, 12, 'The work environment was collaborative and friendly. Office facilities could use some updating.'),
(21, 4, 13, 'Implement a more structured mentorship program for new agents. Regular team building activities would improve morale.'),
(22, 4, 14, 'Yes'),

-- Exit Interview responses for employee 1888
(23, 5, 9, 'Relocating to another city'),
(24, 5, 10, '2025-03-15'),
(25, 5, 11, 'Management was excellent, particularly in providing guidance on difficult transactions.'),
(26, 5, 12, 'Great collaborative environment. Technology resources could be improved.'),
(27, 5, 13, 'Better CRM system and mobile tools for agents in the field would significantly improve efficiency.'),
(28, 5, 14, 'Yes'),

-- Performance Review responses for employee 1945
(29, 6, 15, 'Q1 2025'),
(30, 6, 16, '14'),
(31, 6, 17, '12'),
(32, 6, 18, '7250000'),
(33, 6, 19, '9.3'),
(34, 6, 20, 'Increase listings by 15%, focus on luxury market properties, earn GRI certification'),
(35, 6, 21, 'Luxury property marketing, negotiation skills, investment property analysis'),

-- Performance Review responses for employee 1636
(36, 7, 15, 'Q1 2025'),
(37, 7, 16, '8'),
(38, 7, 17, '7'),
(39, 7, 18, '4500000'),
(40, 7, 19, '9.1'),
(41, 7, 20, 'Expand commercial client base, increase property management portfolio by 20%'),
(42, 7, 21, 'Commercial property financing, lease structure optimization'),

-- Performance Review responses for employee 1888 (rejected submission)
(43, 9, 15, 'Q1 2025'),
(44, 9, 16, '6'),
(45, 9, 17, '5'),
(46, 9, 18, '1900000'),
(47, 9, 19, '8.7'),
(48, 9, 20, 'Increase sales volume'),
(49, 9, 21, ''),

-- Property Showing Feedback responses for employee 1945
(50, 10, 22, '4567 Beach Blvd, Malibu, CA 90265'),
(51, 10, 23, '2025-03-10'),
(52, 10, 24, 'David and Susan Thompson'),
(53, 10, 25, '5'),
(54, 10, 26, 'Clients loved the ocean view and modern kitchen. They had concerns about the size of the master bedroom.'),
(55, 10, 27, 'Clients feel the property is priced fairly given the location and amenities. They may submit an offer next week.'),
(56, 10, 28, 'Yes'),

-- Property Showing Feedback responses for employee 1636
(57, 11, 22, '789 Market Street, Suite 1200, San Francisco, CA 94103'),
(58, 11, 23, '2025-03-12'),
(59, 11, 24, 'TechGrowth Startup Inc.'),
(60, 11, 25, '4'),
(61, 11, 26, 'Client liked the open floor plan and natural lighting. Concerned about parking availability.'),
(62, 11, 27, 'Client feels the lease rate is slightly above market. Would consider if parking spots are included.'),
(63, 11, 28, 'Yes'),

-- Property Showing Feedback responses for employee 1956
(64, 12, 22, '123 Highland Ave, Los Angeles, CA 90036'),
(65, 12, 23, '2025-04-15'),
(66, 12, 24, 'Alex and Maria Rodriguez'),
(67, 12, 25, '3'),
(68, 12, 26, 'Clients liked the neighborhood and backyard. Interior layout does not meet their needs.'),
(69, 12, 27, 'Clients feel the property is overpriced by about 5-7% given the interior condition.'),
(70, 12, 28, 'No'),

-- Commission Structure acknowledgments for employees
(71, 14, 29, '2025-03-15'),
(72, 14, 30, '6.5%'),
(73, 14, 31, '7.0%'),
(74, 14, 32, 'Yes'),

(75, 15, 29, '2025-03-15'),
(76, 15, 30, '6.0%'),
(77, 15, 31, '6.5%'),
(78, 15, 32, 'Yes'),

(79, 16, 29, '2025-03-15'),
(80, 16, 30, '5.5%'),
(81, 16, 31, '6.0%'),
(82, 16, 32, 'Yes'),

-- Training Request responses for employee 1945
(83, 18, 33, 'Advanced Negotiation Techniques for Real Estate Professionals'),
(84, 18, 34, 'National Association of Realtors'),
(85, 18, 35, '2025-03-15'),
(86, 18, 36, '1200'),
(87, 18, 37, 'This course will enhance my negotiation skills for high-value properties and competitive situations, directly benefiting our luxury market clients.'),
(88, 18, 38, 'Yes'),

-- Training Request responses for employee 1636
(89, 19, 33, 'Commercial Real Estate Investment Analysis'),
(90, 19, 34, 'CCIM Institute'),
(91, 19, 35, '2025-04-10'),
(92, 19, 36, '1800'),
(93, 19, 37, 'This course would help me better advise commercial clients on investment property potential and expand our services in the commercial sector.'),
(94, 19, 38, 'Yes'),

-- Training Request responses for employee 1956
(95, 20, 33, 'Digital Marketing for Real Estate'),
(96, 20, 34, 'Real Estate Business Institute'),
(97, 20, 35, '2025-05-20'),
(98, 20, 36, '950'),
(99, 20, 37, 'This course will enhance my online marketing skills and help increase property visibility through social media and digital platforms.'),
(100, 20, 38, 'No'),

-- Expense Reimbursement responses for employee 1945
(101, 21, 39, '2025-03-20'),
(102, 21, 40, 'Client Entertainment'),
(103, 21, 41, '235.78'),
(104, 21, 42, 'receipt_johnson_20250320.pdf'),
(105, 21, 43, 'Business lunch with luxury property clients at Coastal Restaurant. Discussed their real estate needs and potential properties.'),
(106, 21, 44, 'Yes'),
(107, 21, 45, 'Thompson Family'),

-- Expense Reimbursement responses for employee 1636
(108, 22, 39, '2025-04-02'),
(109, 22, 40, 'Marketing Materials'),
(110, 22, 41, '420.50'),
(111, 22, 42, 'invoice_printing_20250402.pdf'),
(112, 22, 43, 'High-quality brochures and presentation folders for commercial property showings.'),
(113, 22, 44, 'No'),
(114, 22, 45, ''),

-- Expense Reimbursement responses for employee 1956
(115, 23, 39, '2025-04-16'),
(116, 23, 40, 'Transportation'),
(117, 23, 41, '142.75'),
(118, 23, 42, 'uber_receipts_20250416.pdf'),
(119, 23, 43, 'Transportation to multiple property showings with out-of-town clients.'),
(120, 23, 44, 'Yes'),
(121, 23, 45, 'Rodriguez Family'),

-- Equipment Request responses for employee 1945
(122, 25, 46, 'Tablet'),
(123, 25, 47, 'iPad Pro 12.9-inch with cellular connectivity'),
(124, 25, 48, 'Need for high-quality property presentations during client meetings and showing luxury properties. Will improve client experience and showcase properties better.'),
(125, 25, 49, 'Medium'),
(126, 25, 50, '1200'),

-- Equipment Request responses for employee 1636
(127, 26, 46, 'Software'),
(128, 26, 47, 'Commercial property analysis software subscription'),
(129, 26, 48, 'Current software is limited for commercial property analysis. New software would allow for better financial projections and visualizations for clients.'),
(130, 26, 49, 'High'),
(131, 26, 50, '950');

-- --------------------------------------------------------

--
-- Table structure for table `digital_signatures`
--

INSERT INTO `digital_signatures` (`id`, `assignment_id`, `signed_by`, `signed_at`, `method`, `signature_data`) VALUES
(1, 1, 1945, '2025-02-12 14:30:00', 'drawn', '{\"points\":[[123,456],[124,457],...]}'),
(2, 2, 1636, '2025-01-07 16:45:00', 'typed', 'Jessica Martinez'),
(3, 4, 1635, '2025-03-20 15:30:00', 'typed', 'David Wilson'),
(4, 5, 1888, '2025-03-05 11:15:00', 'typed', 'Emily Chen'),
(5, 6, 1945, '2025-04-05 16:45:00', 'stored', 'Michael Johnson'),
(6, 7, 1636, '2025-04-03 15:20:00', 'drawn', '{\"points\":[[234,567],[235,568],...]}'),
(7, 10, 1945, '2025-03-10 17:45:00', 'typed', 'Michael Johnson'),
(8, 11, 1636, '2025-03-12 18:30:00', 'typed', 'Jessica Martinez'),
(9, 12, 1956, '2025-04-15 16:30:00', 'typed', 'Thomas Brown'),
(10, 14, 1945, '2025-03-02 14:30:00', 'typed', 'Michael Johnson'),
(11, 15, 1636, '2025-03-03 16:15:00', 'typed', 'Jessica Martinez'),
(12, 16, 1956, '2025-03-02 09:45:00', 'typed', 'Thomas Brown'),
(13, 18, 1945, '2025-02-21 16:30:00', 'drawn', '{\"points\":[[345,678],[346,679],...]}'),
(14, 19, 1636, '2025-03-06 14:45:00', 'typed', 'Jessica Martinez'),
(15, 20, 1956, '2025-04-12 11:45:00', 'typed', 'Thomas Brown'),
(16, 21, 1945, '2025-03-26 16:30:00', 'typed', 'Michael Johnson'),
(17, 22, 1636, '2025-04-06 14:45:00', 'typed', 'Jessica Martinez'),
(18, 23, 1956, '2025-04-19 10:30:00', 'typed', 'Thomas Brown'),
(19, 25, 1945, '2025-03-16 14:30:00', 'typed', 'Michael Johnson'),
(20, 26, 1636, '2025-03-21 16:45:00', 'typed', 'Jessica Martinez');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `assignment_id`, `type`, `message`, `is_read`, `created_at`) VALUES
-- Notifications for HR
(1, 1938, 1, 'submitted', 'Michael Johnson has submitted the Employee Onboarding form.', 1, '2025-02-12 14:30:00'),
(2, 1938, 2, 'submitted', 'Jessica Martinez has submitted the Employee Onboarding form.', 1, '2025-01-07 16:45:00'),
(3, 1938, 4, 'submitted', 'David Wilson has submitted the Exit Interview form.', 0, '2025-03-20 15:30:00'),
(4, 1938, 5, 'submitted', 'Emily Chen has submitted the Exit Interview form.', 1, '2025-03-05 11:15:00'),
(5, 1938, 6, 'submitted', 'Michael Johnson has submitted the Performance Review form.', 0, '2025-04-05 16:45:00'),
(6, 1938, 7, 'submitted', 'Jessica Martinez has submitted the Performance Review form.', 1, '2025-04-03 15:20:00'),
(7, 1938, 9, 'submitted', 'Emily Chen has submitted the Performance Review form.', 1, '2025-04-06 09:15:00'),
(8, 1938, 10, 'submitted', 'Michael Johnson has submitted the Property Showing Feedback form.', 1, '2025-03-10 17:45:00'),
(9, 1938, 11, 'submitted', 'Jessica Martinez has submitted the Property Showing Feedback form.', 1, '2025-03-12 18:30:00'),
(10, 1938, 12, 'submitted', 'Thomas Brown has submitted the Property Showing Feedback form.', 0, '2025-04-15 16:30:00'),
(11, 1938, 20, 'submitted', 'Thomas Brown has submitted the Training Request form.', 0, '2025-04-12 11:45:00'),
(12, 1938, 23, 'submitted', 'Thomas Brown has submitted the Expense Reimbursement form.', 0, '2025-04-19 10:30:00'),

-- Notifications for employee 1945
(13, 1945, 1, 'assigned', 'You have been assigned the Employee Onboarding form.', 1, '2025-02-10 09:15:00'),
(14, 1945, 1, 'approved', 'Your Employee Onboarding form has been approved.', 1, '2025-02-13 10:45:00'),
(15, 1945, 6, 'assigned', 'You have been assigned the Q1 Performance Review form.', 1, '2025-04-01 10:30:00'),
(16, 1945, 10, 'assigned', 'You have been assigned a Property Showing Feedback form.', 1, '2025-03-10 13:15:00'),
(17, 1945, 10, 'approved', 'Your Property Showing Feedback form has been approved.', 1, '2025-03-11 09:30:00'),
(18, 1945, 13, 'assigned', 'You have been assigned a Property Showing Feedback form.', 0, '2025-04-23 15:20:00'),
(19, 1945, 14, 'assigned', 'You have been assigned the Commission Structure Acknowledgment form.', 1, '2025-03-01 10:15:00'),
(20, 1945, 14, 'approved', 'Your Commission Structure Acknowledgment form has been approved.', 1, '2025-03-03 09:45:00'),
(21, 1945, 18, 'assigned', 'You have been assigned a Training Request form.', 1, '2025-02-20 13:45:00'),
(22, 1945, 18, 'approved', 'Your Training Request form has been approved.', 1, '2025-02-22 10:15:00'),
(23, 1945, 21, 'assigned', 'You have been assigned an Expense Reimbursement form.', 1, '2025-03-25 14:15:00'),
(24, 1945, 21, 'approved', 'Your Expense Reimbursement form has been approved.', 1, '2025-03-27 10:45:00'),
(25, 1945, 25, 'assigned', 'You have been assigned an Equipment Request form.', 1, '2025-03-15 10:15:00'),
(26, 1945, 25, 'approved', 'Your Equipment Request form has been approved.', 1, '2025-03-17 09:45:00'),

-- Notifications for employee 1636
(27, 1636, 2, 'assigned', 'You have been assigned the Employee Onboarding form.', 1, '2025-01-05 11:20:00'),
(28, 1636, 2, 'approved', 'Your Employee Onboarding form has been approved.', 1, '2025-01-08 09:30:00'),
(29, 1636, 7, 'assigned', 'You have been assigned the Q1 Performance Review form.', 1, '2025-04-01 10:35:00'),
(30, 1636, 7, 'approved', 'Your Performance Review form has been approved.', 1, '2025-04-04 11:45:00'),
(31, 1636, 11, 'assigned', 'You have been assigned a Property Showing Feedback form.', 1, '2025-03-12 14:20:00'),
(32, 1636, 11, 'approved', 'Your Property Showing Feedback form has been approved.', 1, '2025-03-13 10:45:00'),
(33, 1636, 15, 'assigned', 'You have been assigned the Commission Structure Acknowledgment form.', 1, '2025-03-01 10:20:00'),
(34, 1636, 15, 'approved', 'Your Commission Structure Acknowledgment form has been approved.', 1, '2025-03-04 11:30:00'),
(35, 1636, 19, 'assigned', 'You have been assigned a Training Request form.', 1, '2025-03-05 11:20:00'),
(36, 1636, 19, 'rejected', 'Your Training Request form has been rejected. See remarks for details.', 1, '2025-03-07 09:30:00'),
(37, 1636, 22, 'assigned', 'You have been assigned an Expense Reimbursement form.', 1, '2025-04-05 11:30:00'),
(38, 1636, 22, 'approved', 'Your Expense Reimbursement form has been approved.', 1, '2025-04-07 09:30:00'),
(39, 1636, 26, 'assigned', 'You have been assigned an Equipment Request form.', 1, '2025-03-20 11:30:00'),
(40, 1636, 26, 'rejected', 'Your Equipment Request form has been rejected. See remarks for details.', 1, '2025-03-22 10:30:00'),

-- Notifications for employee 1956
(41, 1956, 3, 'assigned', 'You have been assigned the Employee Onboarding form.', 0, '2025-04-22 13:30:00'),
(42, 1956, 8, 'assigned', 'You have been assigned the Q1 Performance Review form.', 0, '2025-04-01 10:40:00'),
(43, 1956, 8, 'reminder', 'Reminder: Your Performance Review form is due by April 25.', 0, '2025-04-20 09:00:00'),
(44, 1956, 12, 'assigned', 'You have been assigned a Property Showing Feedback form.', 1, '2025-04-15 09:45:00'),
(45, 1956, 16, 'assigned', 'You have been assigned the Commission Structure Acknowledgment form.', 1, '2025-03-01 10:25:00'),
(46, 1956, 16, 'approved', 'Your Commission Structure Acknowledgment form has been approved.', 1, '2025-03-03 14:20:00'),
(47, 1956, 20, 'assigned', 'You have been assigned a Training Request form.', 1, '2025-04-10 15:30:00'),
(48, 1956, 23, 'assigned', 'You have been assigned an Expense Reimbursement form.', 1, '2025-04-18 15:20:00'),
(49, 1956, 27, 'assigned', 'You have been assigned an Equipment Request form.', 0, '2025-04-23 15:30:00'),

-- Notifications for employee 1635
(50, 1635, 4, 'assigned', 'You have been assigned the Exit Interview form.', 1, '2025-03-15 14:45:00'),

-- Notifications for employee 1888
(51, 1888, 5, 'assigned', 'You have been assigned the Exit Interview form.', 1, '2025-02-28 16:20:00'),
(52, 1888, 5, 'approved', 'Your Exit Interview form has been processed. Thank you for your feedback.', 1, '2025-03-06 14:30:00'),
(53, 1888, 9, 'assigned', 'You have been assigned the Q1 Performance Review form.', 1, '2025-04-01 10:45:00'),
(54, 1888, 9, 'rejected', 'Your Performance Review form has been returned for revision. Please provide more details.', 1, '2025-04-07 14:30:00'),
(55, 1888, 17, 'assigned', 'You have been assigned the Commission Structure Acknowledgment form.', 0, '2025-03-01 10:30:00'),
(56, 1888, 17, 'reminder', 'Reminder: Please acknowledge the new commission structure ASAP.', 0, '2025-04-15 09:00:00'),
(57, 1888, 24, 'assigned', 'You have been assigned an Expense Reimbursement form.', 0, '2025-04-22 13:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `action`, `user_id`, `target_id`, `context`, `details`, `timestamp`) VALUES
-- Audit logs for form assignments
(1, 'assigned', 1938, 1, 'assignment', '{\"template_id\": 1, \"assigned_to\": 1945, \"status\": \"pending\"}', '2025-02-10 09:15:00'),
(2, 'submitted', 1945, 1, 'assignment', '{\"status\": \"submitted\"}', '2025-02-12 14:30:00'),
(3, 'reviewed', 1938, 1, 'assignment', '{\"status\": \"approved\", \"remarks\": \"All documentation complete and properly filled.\"}', '2025-02-13 10:45:00'),
(4, 'assigned', 1938, 2, 'assignment', '{\"template_id\": 1, \"assigned_to\": 1636, \"status\": \"pending\"}', '2025-01-05 11:20:00'),
(5, 'submitted', 1636, 2, 'assignment', '{\"status\": \"submitted\"}', '2025-01-07 16:45:00'),
(6, 'reviewed', 1938, 2, 'assignment', '{\"status\": \"approved\", \"remarks\": \"Welcome to the team!\"}', '2025-01-08 09:30:00'),
(7, 'assigned', 1938, 3, 'assignment', '{\"template_id\": 1, \"assigned_to\": 1956, \"status\": \"pending\"}', '2025-04-22 13:30:00'),
(8, 'assigned', 1938, 4, 'assignment', '{\"template_id\": 2, \"assigned_to\": 1635, \"status\": \"pending\"}', '2025-03-15 14:45:00'),
(9, 'submitted', 1635, 4, 'assignment', '{\"status\": \"submitted\"}', '2025-03-20 15:30:00'),
(10, 'assigned', 1938, 5, 'assignment', '{\"template_id\": 2, \"assigned_to\": 1888, \"status\": \"pending\"}', '2025-02-28 16:20:00'),
(11, 'submitted', 1888, 5, 'assignment', '{\"status\": \"submitted\"}', '2025-03-05 11:15:00'),
(12, 'reviewed', 1938, 5, 'assignment', '{\"status\": \"approved\", \"remarks\": \"We appreciate your feedback and wish you well in your future endeavors.\"}', '2025-03-06 14:30:00'),
(13, 'assigned', 1938, 6, 'assignment', '{\"template_id\": 3, \"assigned_to\": 1945, \"status\": \"pending\"}', '2025-04-01 10:30:00'),
(14, 'submitted', 1945, 6, 'assignment', '{\"status\": \"submitted\"}', '2025-04-05 16:45:00'),
(15, 'assigned', 1938, 7, 'assignment', '{\"template_id\": 3, \"assigned_to\": 1636, \"status\": \"pending\"}', '2025-04-01 10:35:00'),
(16, 'submitted', 1636, 7, 'assignment', '{\"status\": \"submitted\"}', '2025-04-03 15:20:00'),
(17, 'reviewed', 1938, 7, 'assignment', '{\"status\": \"approved\", \"remarks\": \"Excellent performance this quarter. Keep up the good work!\"}', '2025-04-04 11:45:00'),
(18, 'assigned', 1938, 8, 'assignment', '{\"template_id\": 3, \"assigned_to\": 1956, \"status\": \"pending\"}', '2025-04-01 10:40:00'),
(19, 'assigned', 1938, 9, 'assignment', '{\"template_id\": 3, \"assigned_to\": 1888, \"status\": \"pending\"}', '2025-04-01 10:45:00'),
(20, 'submitted', 1888, 9, 'assignment', '{\"status\": \"submitted\"}', '2025-04-06 09:15:00'),
(21, 'reviewed', 1938, 9, 'assignment', '{\"status\": \"rejected\", \"remarks\": \"Please provide more details on client acquisition strategies\"}', '2025-04-07 14:30:00'),
(22, 'assigned', 1938, 10, 'assignment', '{\"template_id\": 4, \"assigned_to\": 1945, \"status\": \"pending\"}', '2025-03-10 13:15:00'),
(23, 'submitted', 1945, 10, 'assignment', '{\"status\": \"submitted\"}', '2025-03-10 17:45:00'),
(24, 'reviewed', 1938, 10, 'assignment', '{\"status\": \"approved\", \"remarks\": \"Great detailed feedback\"}', '2025-03-11 09:30:00'),
(25, 'assigned', 1938, 11, 'assignment', '{\"template_id\": 4, \"assigned_to\": 1636, \"status\": \"pending\"}', '2025-03-12 14:20:00'),
(26, 'submitted', 1636, 11, 'assignment', '{\"status\": \"submitted\"}', '2025-03-12 18:30:00'),
(27, 'reviewed', 1938, 11, 'assignment', '{\"status\": \"approved\", \"remarks\": \"Follow up with client scheduled\"}', '2025-03-13 10:45:00'),
(28, 'assigned', 1938, 12, 'assignment', '{\"template_id\": 4, \"assigned_to\": 1956, \"status\": \"pending\"}', '2025-04-15 09:45:00'),
(29, 'submitted', 1956, 12, 'assignment', '{\"status\": \"submitted\"}', '2025-04-15 16:30:00'),
(30, 'assigned', 1938, 13, 'assignment', '{\"template_id\": 4, \"assigned_to\": 1945, \"status\": \"pending\"}', '2025-04-23 15:20:00'),

-- Continue with more audit logs
(31, 'created', 1938, 1, 'template', '{\"title\": \"Employee Onboarding\", \"is_active\": true}', '2025-01-15 09:30:00'),
(32, 'created', 1938, 2, 'template', '{\"title\": \"Exit Interview\", \"is_active\": true}', '2025-01-16 10:45:00'),
(33, 'created', 1938, 3, 'template', '{\"title\": \"Performance Review\", \"is_active\": true}', '2025-01-20 14:30:00'),
(34, 'created', 1938, 4, 'template', '{\"title\": \"Property Showing Feedback\", \"is_active\": true}', '2025-02-05 11:15:00'),
(35, 'created', 1938, 5, 'template', '{\"title\": \"Commission Structure Acknowledgment\", \"is_active\": true}', '2025-03-01 15:30:00'),
(36, 'created', 1938, 6, 'template', '{\"title\": \"Training Request\", \"is_active\": true}', '2025-03-10 13:45:00'),
(37, 'created', 1938, 7, 'template', '{\"title\": \"Expense Reimbursement\", \"is_active\": true}', '2025-02-15 09:15:00'),
(38, 'created', 1938, 8, 'template', '{\"title\": \"Equipment Request\", \"is_active\": true}', '2025-02-18 14:20:00'),
(39, 'updated', 1938, 1, 'template', '{\"description\": \"Comprehensive form for onboarding new real estate agents and staff\"}', '2025-03-22 14:15:00'),
(40, 'updated', 1938, 3, 'template', '{\"description\": \"Quarterly performance evaluation for real estate agents\"}', '2025-04-10 16:45:00'),

(41, 'signed', 1945, 1, 'signature', '{\"method\": \"drawn\", \"assignment_id\": 1}', '2025-02-12 14:30:00'),
(42, 'signed', 1636, 2, 'signature', '{\"method\": \"typed\", \"assignment_id\": 2}', '2025-01-07 16:45:00'),
(43, 'signed', 1635, 4, 'signature', '{\"method\": \"typed\", \"assignment_id\": 4}', '2025-03-20 15:30:00'),
(44, 'signed', 1888, 5, 'signature', '{\"method\": \"typed\", \"assignment_id\": 5}', '2025-03-05 11:15:00'),
(45, 'signed', 1945, 6, 'signature', '{\"method\": \"stored\", \"assignment_id\": 6}', '2025-04-05 16:45:00'),
(46, 'signed', 1636, 7, 'signature', '{\"method\": \"drawn\", \"assignment_id\": 7}', '2025-04-03 15:20:00'),

(47, 'login', 1938, null, 'authentication', '{\"ip\": \"192.168.1.45\", \"user_agent\": \"Mozilla/5.0\"}', '2025-04-23 08:30:15'),
(48, 'login', 1945, null, 'authentication', '{\"ip\": \"192.168.1.87\", \"user_agent\": \"Chrome/120.0.0.0\"}', '2025-04-23 09:45:22'),
(49, 'login', 1636, null, 'authentication', '{\"ip\": \"192.168.1.92\", \"user_agent\": \"Safari/615.1\"}', '2025-04-23 10:15:18'),
(50, 'login', 1956, null, 'authentication', '{\"ip\": \"192.168.1.105\", \"user_agent\": \"Firefox/115.0\"}', '2025-04-23 11:20:45'),
(51, 'failed_login', 1888, null, 'authentication', '{\"ip\": \"192.168.1.120\", \"user_agent\": \"Chrome/120.0.0.0\", \"reason\": \"invalid_password\"}', '2025-04-23 13:10:30'),
(52, 'login', 1888, null, 'authentication', '{\"ip\": \"192.168.1.120\", \"user_agent\": \"Chrome/120.0.0.0\"}', '2025-04-23 13:11:45'),
(53, 'login', 1635, null, 'authentication', '{\"ip\": \"192.168.1.67\", \"user_agent\": \"Edge/120.0.0.0\"}', '2025-04-23 14:30:20'),
(54, 'password_reset', 1945, null, 'authentication', '{\"ip\": \"192.168.1.87\", \"user_agent\": \"Chrome/120.0.0.0\"}', '2025-04-15 10:45:15');

-- --------------------------------------------------------

--
-- Table structure for table `hr_config`
--

INSERT INTO `hr_config` (`id`, `config_key`, `value`) VALUES
(1, 'hr_user_ids', '[1938]'),
(2, 'notification_settings', '{\"send_email\": true, \"send_in_app\": true, \"reminder_days\": 3}'),
(3, 'form_settings', '{\"require_signature\": true, \"auto_save\": true, \"max_file_upload_size\": 10}'),
(4, 'company_details', '{\"name\": \"GoldenKey Real Estate\", \"address\": \"123 Main Street, Suite 500, Los Angeles, CA 90001\", \"phone\": \"(555) 123-4567\", \"email\": \"hr@goldenkey.com\", \"website\": \"www.goldenkey-realestate.com\"}'),
(5, 'department_list', '[\"Residential Sales\", \"Commercial Sales\", \"Property Management\", \"Marketing\", \"Administration\", \"Finance\", \"Legal\", \"Human Resources\"]'),
(6, 'position_list', '[\"Real Estate Agent\", \"Senior Real Estate Agent\", \"Broker\", \"Office Manager\", \"Marketing Specialist\", \"Administrative Assistant\", \"Property Manager\", \"Finance Analyst\", \"HR Specialist\", \"Legal Counsel\"]'),
(7, 'signature_settings', '{\"allowed_methods\": [\"drawn\", \"typed\", \"stored\"], \"store_timestamp\": true, \"require_confirmation\": true}'),
(8, 'fiscal_year', '{\"start_month\": 1, \"start_day\": 1}'),
(9, 'logo_path', '/assets/images/company_logo.png'),
(10, 'document_retention', '{\"employee_forms\": 7, \"financial_forms\": 10, \"general_forms\": 3}');