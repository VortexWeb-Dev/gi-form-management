-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 02, 2025 at 08:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gi-form-management`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `action` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `context` varchar(50) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `digital_signatures`
--

CREATE TABLE `digital_signatures` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `signed_by` int(11) DEFAULT NULL,
  `signed_at` datetime DEFAULT NULL,
  `method` enum('drawn','typed','stored') DEFAULT NULL,
  `signature_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_assignments`
--

CREATE TABLE `form_assignments` (
  `id` int(11) NOT NULL,
  `template_id` int(11) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `assigned_by` int(11) DEFAULT NULL,
  `status` enum('pending','submitted','approved','rejected') DEFAULT NULL,
  `assigned_at` datetime DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_fields`
--

CREATE TABLE `form_fields` (
  `id` int(11) NOT NULL,
  `template_id` int(11) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `is_required` tinyint(1) DEFAULT NULL,
  `field_order` int(11) DEFAULT NULL,
  `placeholder` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_fields`
--

INSERT INTO `form_fields` (`id`, `template_id`, `label`, `type`, `is_required`, `field_order`, `placeholder`) VALUES
(51, 34, 'Employee Name', 'text', 1, 1, 'Please enter your name'),
(52, 34, 'Date Issued', 'date', 1, 2, ''),
(53, 34, 'SR 1', 'text', 1, 3, NULL),
(54, 34, 'SR 2', 'text', 0, 4, NULL),
(55, 34, 'SR 3', 'text', 0, 5, NULL),
(56, 34, 'ITEM DESCRIPTION 1', 'text', 1, 3, NULL),
(57, 34, 'ITEM DESCRIPTION 2', 'text', 0, 4, NULL),
(58, 34, 'ITEM DESCRIPTION 3', 'text', 0, 5, NULL),
(59, 34, 'PURPOSE 1', 'text', 1, 3, NULL),
(60, 34, 'PURPOSE 2', 'text', 0, 4, NULL),
(61, 34, 'PURPOSE 3', 'text', 0, 5, NULL),
(62, 34, 'Employment Code', 'text', 1, 6, 'Please enter employee code'),
(63, 34, 'Signature', 'text', 1, 7, 'Please enter your signature (Full Name)');

-- --------------------------------------------------------

--
-- Table structure for table `form_responses`
--

CREATE TABLE `form_responses` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `field_id` int(11) DEFAULT NULL,
  `response_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_templates`
--

CREATE TABLE `form_templates` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `type` enum('onboarding','offboarding','operation','policy','legal') DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_templates`
--

INSERT INTO `form_templates` (`id`, `title`, `description`, `type`, `file_path`, `created_by`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'Certificate of Employment', 'Official certificate confirming employee’s tenure and role at the company.', 'onboarding', 'template/certificate_of_employment_rev_1_0.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(2, 'Recommendation Letter', 'Template for providing employment or character recommendations for former employees.', 'onboarding', 'template/recommendation_rev_1_2.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(3, 'Separation Policy', 'Guidelines and policies regarding employee separation and offboarding.', 'onboarding', 'template/separation_policy.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(4, 'Employee Checklist', 'Checklist for employees during onboarding or offboarding processes.', 'onboarding', 'template/employee_checklist_rev_1_1.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(5, 'Applicant Screening Form', 'Form to assist in evaluating candidates during the recruitment process.', 'onboarding', 'template/applicant_screening_rev_1_1.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(6, 'Content Use and Media Rights Consent Agreement', 'Consent form for the use of employee images, content, and media rights.', 'onboarding', 'template/content_use_and_media_rights_consent_agreement.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(7, 'Increment Letter', 'Official communication of an employee’s salary increment.', 'onboarding', 'template/increment_letter.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(8, 'Salary Certificate', 'Document certifying an employee’s salary for official purposes.', 'onboarding', 'template/salary_certificate.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(9, 'Termination Form', 'Form used to document employee terminations.', 'onboarding', 'template/termination_form.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(10, 'Exit Interview Form', 'Structured form for conducting exit interviews with departing employees.', 'onboarding', 'template/exit_interview_rev_1_0.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(11, 'Release from Duties Form', 'Acknowledgment form for the release of an employee from duties.', 'onboarding', 'template/release_from_duties_form.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(12, 'Parking Policy', 'Company policy regarding parking facilities and access.', 'onboarding', 'template/parking_policy.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(13, 'Parking Access Policy', 'Rules and procedures for accessing company parking areas.', 'onboarding', 'template/parking_access_policy.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(14, 'Onboarding Checklist', 'Checklist to assist HR and managers in onboarding new hires.', 'onboarding', 'template/onboarding_checklist.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(15, 'General Behavior Policy', 'Policy outlining expected employee behavior and conduct.', 'onboarding', 'template/general_behavior_policy_rev_1_1.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(16, 'Non-Disclosure Agreement (NDA)', 'Agreement to protect confidential company information.', 'onboarding', 'template/nda_edited_2025_04_04.docx', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(17, 'GI PIN Form', 'Internal form related to GI PIN issuance.', 'onboarding', 'template/gi_pin.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(18, 'Evaluation Form', 'Template for employee performance evaluation.', 'onboarding', 'template/evaluation_form_rev_1_0.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(19, 'Evaluation Form for Recruiters', 'Specialized evaluation form for recruitment performance.', 'onboarding', 'template/evaluation_form_recruiters.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(20, 'Target and Commission Structure', 'Details of employee targets and commission structures for 2025.', 'onboarding', 'template/target_and_commission_structure_2025.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(21, 'End of Service Form', 'Form related to end of service process and benefits.', 'onboarding', 'template/end_of_service_rev_1_0.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(22, 'Sick Leave Policy', 'Company policy regarding sick leave entitlements and procedures.', 'onboarding', 'template/sick_leave_policy_rev_1_0.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(23, 'Health Questionnaire', 'Employee health information questionnaire.', 'onboarding', 'template/health_questionnaire.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(24, 'Final Settlement Form', 'Template for calculating and acknowledging final settlements.', 'onboarding', 'template/final_settlement_rev_1_0.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(25, 'Proof of Employment Letter', 'Letter template confirming employment for external use.', 'onboarding', 'template/proof_of_employment_letter.docx', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(26, 'No Disclosure Agreement (NDA) Rev 1.1', 'Updated version of the no disclosure agreement.', 'onboarding', 'template/NDA Edit Drafts/nda_edit_drafts_no_disclosure_agreement_nda_rev_1_1.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(27, 'No Disclosure Agreement (NDA) Rev 1.0', 'Original version of the no disclosure agreement.', 'onboarding', 'template/NDA Edit Drafts/nda_edit_drafts_no_disclosure_agreement_nda_rev_1_0.docx', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(28, 'Non-Compete Agreement', 'Agreement restricting employee’s ability to work with competitors.', 'onboarding', 'template/NDA Edit Drafts/nda_edit_drafts_non_compete_agreement.docx', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(29, 'Dress Code Policy', 'Policy document outlining company dress code expectations.', 'onboarding', 'template/dress_code.docx', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(30, 'Advance Request Form', 'Form for employees to request financial advances.', 'onboarding', 'template/advance_form.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(31, 'Attendance Policy - Back Office', 'Attendance rules and regulations for back office employees.', 'onboarding', 'template/attendance_policy_back_office_rev_1_1.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(32, 'Employee Referral Program', 'Program details for employee-driven candidate referrals.', 'onboarding', 'template/employee_referral_program.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(33, 'Code of Conduct Policy', 'Guidelines on professional and ethical behavior expected from employees.', 'onboarding', 'template/code_of_conduct_policy.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(34, 'Acknowledgment of Company Assets Receipt', 'Form for employees to acknowledge receipt of company assets.', 'onboarding', 'template/acknowledgment_of_company_assets_receipt_rev_1_0.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(35, 'Marketing Communication Procedure', 'Procedures for internal and external marketing communications.', 'onboarding', 'template/marketing_communication_procedure.docx', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(36, 'New Employee Onboarding Checklist', 'Checklist for successfully onboarding new hires.', 'onboarding', 'template/employee_onboarding_checklist_new.docx', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(37, 'Personal Details Form', 'Form for collecting new hire personal details.', 'onboarding', 'template/personal_details.docx', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(38, 'Primary Evaluation Sheet', 'Evaluation sheet template for primary level assessments.', 'onboarding', 'template/evaluation_sheet_primary_rev_1_0.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(39, 'Exit Clearance Form', 'Form to ensure all exit formalities are completed.', 'onboarding', 'template/exit_clearance.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(40, 'Secondary Evaluation Form', 'Template for secondary stage employee evaluations.', 'onboarding', 'template/evaluation_form_secondary.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(41, 'Leave Form', 'Employee application form for leaves of absence.', 'onboarding', 'template/leave_form.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1),
(42, 'Social Media Policy', 'Company policy regarding employee use of social media.', 'onboarding', 'template/social_media_policy.dot', 1938, '2025-04-26 16:43:50', '2025-04-26 16:43:50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hr_config`
--

CREATE TABLE `hr_config` (
  `id` int(11) NOT NULL,
  `config_key` varchar(100) DEFAULT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `type` enum('assigned','submitted','reminder','reviewed','approved','rejected') DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `digital_signatures`
--
ALTER TABLE `digital_signatures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_id` (`assignment_id`);

--
-- Indexes for table `form_assignments`
--
ALTER TABLE `form_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `template_id` (`template_id`);

--
-- Indexes for table `form_fields`
--
ALTER TABLE `form_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `template_id` (`template_id`);

--
-- Indexes for table `form_responses`
--
ALTER TABLE `form_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_id` (`assignment_id`),
  ADD KEY `field_id` (`field_id`);

--
-- Indexes for table `form_templates`
--
ALTER TABLE `form_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hr_config`
--
ALTER TABLE `hr_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_id` (`assignment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `digital_signatures`
--
ALTER TABLE `digital_signatures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `form_assignments`
--
ALTER TABLE `form_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `form_fields`
--
ALTER TABLE `form_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `form_responses`
--
ALTER TABLE `form_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `form_templates`
--
ALTER TABLE `form_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `hr_config`
--
ALTER TABLE `hr_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `digital_signatures`
--
ALTER TABLE `digital_signatures`
  ADD CONSTRAINT `digital_signatures_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `form_assignments` (`id`);

--
-- Constraints for table `form_assignments`
--
ALTER TABLE `form_assignments`
  ADD CONSTRAINT `form_assignments_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `form_templates` (`id`);

--
-- Constraints for table `form_fields`
--
ALTER TABLE `form_fields`
  ADD CONSTRAINT `form_fields_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `form_templates` (`id`);

--
-- Constraints for table `form_responses`
--
ALTER TABLE `form_responses`
  ADD CONSTRAINT `form_responses_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `form_assignments` (`id`),
  ADD CONSTRAINT `form_responses_ibfk_2` FOREIGN KEY (`field_id`) REFERENCES `form_fields` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `form_assignments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;