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
    type ENUM('assigned', 'submitted', 'reminder'),
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

-- form_templates
INSERT INTO form_templates (title, description, file_path, created_by, created_at, updated_at, is_active) VALUES
('Employee Onboarding', 'Form for onboarding new hires', '/files/onboarding.pdf', 101, NOW(), NOW(), TRUE),
('Exit Interview', 'Feedback form for resigning employees', '/files/exit.docx', 102, NOW(), NOW(), TRUE);

-- form_fields
INSERT INTO form_fields (template_id, label, type, is_required, field_order, placeholder) VALUES
(1, 'Full Name', 'text', TRUE, 1, 'Enter your full name'),
(1, 'Date of Joining', 'date', TRUE, 2, ''),
(1, 'Department', 'text', FALSE, 3, 'HR, IT, etc.');

-- form_assignments
INSERT INTO form_assignments (template_id, assigned_to, assigned_by, status, assigned_at, submitted_at, reviewed_at, remarks) VALUES
(1, 201, 101, 'pending', NOW(), NULL, NULL, NULL),
(2, 202, 102, 'submitted', NOW(), NOW(), NOW(), 'Well answered');

-- form_responses
INSERT INTO form_responses (assignment_id, field_id, response_value) VALUES
(1, 1, 'John Doe'),
(1, 2, '2024-03-01'),
(2, 1, 'Jane Smith');

-- digital_signatures
INSERT INTO digital_signatures (assignment_id, signed_by, signed_at, method, signature_data) VALUES
(2, 202, NOW(), 'typed', 'Jane Smith');

-- audit_logs
INSERT INTO audit_logs (action, user_id, target_id, context, details, timestamp) VALUES
('assigned', 101, 1, 'assignment', '{"status": "pending"}', NOW()),
('submitted', 202, 2, 'assignment', '{"status": "submitted"}', NOW());

-- notifications
INSERT INTO notifications (user_id, assignment_id, type, message, is_read, created_at) VALUES
(201, 1, 'assigned', 'You have been assigned a new form.', FALSE, NOW()),
(202, 2, 'submitted', 'You submitted the form.', TRUE, NOW());

-- hr_config
INSERT INTO hr_config (`config_key`, `value`) VALUES
('hr_user_ids', '[101, 102]');
