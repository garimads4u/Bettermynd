<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Name:  Auth Lang - English
 *
 * Author: Ben Edmunds
 * 		  ben.edmunds@gmail.com
 *         @benedmunds
 *
 * Author: Daniel Davis
 *         @ourmaninjapan
 *
 * Location: http://github.com/benedmunds/ion_auth/
 *
 * Created:  03.09.2013
 *
 * Description:  English language file for Ion Auth example views
 *
 */
// Errors
$lang['error_csrf'] = 'This form post did not pass our security checks.';

// Login
$lang['login_heading'] = 'LOGIN TO THE APP';
$lang['login_subheading'] = 'This is the best app ever!'; //'Please login with your email/username and password below.';
$lang['login_identity_label'] = 'Email Address';
$lang['login_company_identity_label'] = 'Username';

$lang['login_password_label'] = 'Password';
$lang['login_remember_label'] = 'Remember Me';
$lang['login_submit_btn'] = 'Login';
$lang['login_forgot_password'] = 'Forgot your password?';

// Index
$lang['index_heading'] = 'Users';
$lang['index_subheading'] = 'Below is a list of the users.';
$lang['index_fname_th'] = 'First Name';
$lang['index_lname_th'] = 'Last Name';
$lang['index_email_th'] = 'Email';
$lang['index_groups_th'] = 'Groups';
$lang['index_status_th'] = 'Status';
$lang['index_action_th'] = 'Action';
$lang['index_active_link'] = 'Active';
$lang['index_inactive_link'] = 'Inactive';
$lang['index_create_user_link'] = 'Create a new user';
$lang['index_create_group_link'] = 'Create a new group';

// Deactivate User
$lang['deactivate_heading'] = 'Deactivate User';
$lang['deactivate_subheading'] = 'Are you sure you want to deactivate the user \'%s\'';
$lang['deactivate_confirm_y_label'] = 'Yes:';
$lang['deactivate_confirm_n_label'] = 'No:';
$lang['deactivate_submit_btn'] = 'Submit';
$lang['deactivate_validation_confirm_label'] = 'confirmation';
$lang['deactivate_validation_user_id_label'] = 'user ID';

// Create User
$lang['create_user_heading'] = 'Registration';
$lang['create_user_subheading'] = 'Register as a User to Access Branded Material'; //'Please enter the user\'s information below.';
$lang['create_company_subheading'] = 'Register as a Company to Access Branded Material'; //'Please enter the user\'s information below.';
$lang['create_affiliate_subheading'] = 'Register as a Affiliate to Access Branded Material'; //'Please enter the user\'s information below.';

$lang['create_user_fname_label'] = 'First Name';
$lang['create_user_lname_label'] = 'Last Name';
$lang['create_user_company_label'] = 'Company Name';
$lang['create_user_identity_label'] = 'Username';
$lang['create_user_email_label'] = 'Email Address';
$lang['create_user_confirm_email_label'] = 'Repeat Email Address';
$lang['create_user_phone_label'] = 'Phone';
$lang['create_user_password_label'] = 'Password';
$lang['create_user_password_confirm_label'] = 'Repeat Password';
$lang['create_user_submit_btn'] = 'Register';
$lang['create_user_validation_fname_label'] = 'First Name';
$lang['create_user_validation_lname_label'] = 'Last Name';
$lang['create_user_validation_identity_label'] = 'Username';
$lang['create_user_validation_email_label'] = 'Email Address';
$lang['create_user_validation_phone_label'] = 'Phone';
$lang['create_user_validation_patient_id_label'] = 'Identification Number';
$lang['create_user_validation_dob_label'] = 'Date Of Birth';
$lang['create_user_validation_mobile_no_label'] = 'Mobile Number';
$lang['create_user_validation_college_label'] = 'College Name';
$lang['create_user_validation_address_label'] = 'Address';
$lang['create_user_validation_city_label'] = 'City';
$lang['create_user_validation_state_label'] = 'State';
$lang['create_user_validation_zipcode_label'] = 'Zipcode';
$lang['create_user_validation_office_label'] = 'Office No.';
$lang['create_user_validation_cost_label'] = 'Average rate per 45 minute session ($)';
$lang['create_user_validation_biography_label'] = 'Biography';
$lang['create_user_validation_specialities_label'] = 'Specialities';
$lang['create_user_validation_insurance_carriers_label'] = 'Health Insurance';

$lang['create_user_validation_password_label'] = 'Password';
$lang['create_user_validation_password_confirm_label'] = 'Password Confirmation';


$lang['create_user_credit_card_label'] = 'Credit Card';
$lang['create_user_newsletter_label'] = 'Sign up for our newsletter';
$lang['create_user_terms_service_label'] = 'Agree to the Terms of Service';
$lang['create_user_full_name_card_label'] = 'Full Name';
$lang['create_user_first_name_card_label'] = 'First Name';
$lang['create_user_last_name_card_label'] = 'Last Name';
$lang['create_user_card_number_label'] = 'Credit Card Number';
$lang['create_user_card_expiration_number_label'] = 'Expiration Date';
$lang['create_user_card_cvv_number_label'] = 'CVV Code';
$lang['create_user_address_label'] = 'Address';
$lang['create_user_zip_code_label'] = 'Zip Code';
$lang['create_user_apply_coupon_label'] = 'Apply Discount Code';
$lang['create_user_validation_college_zipcode_label'] = 'College Zip Code';
$lang['create_user_validation_college_city_label'] = 'College City';
$lang['create_user_validation_college_state_label'] = 'College State';
$lang['create_user_validation_college_address_label'] = 'College Address';
$lang['create_user_validation_college_office_label'] = 'Office No.';


// Edit User
$lang['edit_user_heading'] = 'Edit User';
$lang['edit_user_subheading'] = 'Please enter the user\'s information below.';
$lang['edit_user_fname_label'] = 'First Name';
$lang['edit_user_lname_label'] = 'Last Name';
$lang['edit_user_company_label'] = 'Company Name';
$lang['edit_user_email_label'] = 'Email Address';
$lang['edit_user_phone_label'] = 'Mobile Phone';
$lang['edit_user_password_label'] = 'Password: (if changing password)';
$lang['edit_user_password_confirm_label'] = 'Confirm Password: (if changing password)';
$lang['edit_user_groups_heading'] = 'Member of groups';
$lang['edit_user_submit_btn'] = 'Save';
$lang['edit_user_validation_fname_label'] = 'First Name';
$lang['edit_user_validation_lname_label'] = 'Last Name';
$lang['edit_user_validation_email_label'] = 'Email Address';
$lang['edit_user_validation_phone_label'] = 'Phone';
$lang['edit_user_validation_company_label'] = 'Company Name';
$lang['edit_user_validation_groups_label'] = 'Groups';
$lang['edit_user_validation_password_label'] = 'Password';
$lang['edit_user_validation_password_confirm_label'] = 'Password Confirmation';
$lang['edit_user_identity_label'] = 'Username';
$lang['edit_user_office_number_label'] = 'Office Phone';
$lang['edit_user_address_label'] = 'Mailing Address';
$lang['edit_user_state_label'] = 'State';
$lang['edit_user_zipcode_label'] = 'Zip Code';
$lang['edit_user_website_label'] = 'Website';
$lang['edit_user_fax_number_label'] = 'Fax Number';
$lang['edit_user_profile_pic_label'] = 'Headshot Photo';
$lang['edit_user_company_logo_label'] = 'Secondary Company Logo';
$lang['edit_user_social_media_label'] = 'Social Media';

// Create Group
$lang['create_group_title'] = 'Create Group';
$lang['create_group_heading'] = 'Create Group';
$lang['create_group_subheading'] = 'Please enter the group information below.';
$lang['create_group_name_label'] = 'Group Name';
$lang['create_group_desc_label'] = 'Description:';
$lang['create_group_submit_btn'] = 'Create Group';
$lang['create_group_validation_name_label'] = 'Group Name';
$lang['create_group_validation_desc_label'] = 'Description';

// Edit Group
$lang['edit_group_title'] = 'Edit Group';
$lang['edit_group_saved'] = 'Group Saved';
$lang['edit_group_heading'] = 'Edit Group';
$lang['edit_group_subheading'] = 'Please enter the group information below.';
$lang['edit_group_name_label'] = 'Group Name:';
$lang['edit_group_desc_label'] = 'Description:';
$lang['edit_group_submit_btn'] = 'Save Group';
$lang['edit_group_validation_name_label'] = 'Group Name';
$lang['edit_group_validation_desc_label'] = 'Description';

// Change Password
$lang['change_password_heading'] = 'Change Password';
$lang['change_password_old_password_label'] = 'Old Password:';
$lang['change_password_new_password_label'] = 'New Password:';
$lang['change_password_new_password_confirm_label'] = 'Confirm New Password:';
$lang['change_password_submit_btn'] = 'Change';
$lang['change_password_validation_old_password_label'] = 'Old Password';
$lang['change_password_validation_new_password_label'] = 'New Password';
$lang['change_password_validation_new_password_confirm_label'] = 'Confirm New Password';

// Forgot Password
$lang['forgot_password_heading'] = 'Forgot Password';
$lang['forgot_password_subheading'] = 'Please enter your %s so we can send you an email to reset your password.';
$lang['forgot_password_email_label'] = 'Email Address';
$lang['forgot_password_submit_btn'] = 'Submit';
$lang['forgot_password_validation_email_label'] = 'Email Address';
$lang['forgot_password_identity_label'] = 'Username';
$lang['forgot_password_email_identity_label'] = 'Email';
$lang['forgot_password_email_not_found'] = 'No record of that email address.';

// Reset Password
$lang['reset_password_heading'] = 'Change Password';
$lang['set_password_heading'] = 'Set Password';
$lang['reset_password_new_password_label'] = 'New Password:';
$lang['reset_password_new_password_confirm_label'] = 'Confirm New Password:';
$lang['reset_password_submit_btn'] = 'Change';
$lang['save_submit_btn'] = 'Save';
$lang['reset_password_validation_new_password_label'] = 'New Password';
$lang['reset_password_validation_new_password_confirm_label'] = 'Confirm New Password';

//dashboard label
$lang['logout_confirm_button_confirm_label'] = 'Yes, please';
$lang['logout_confirm_button_cancel_label'] = 'No, thanks';
$lang['logout_confirm_message_label'] = 'Do you really want to logout from this session?';

//Company Profile
$lang['edit_company_profile_submit_label'] = 'Save and Continue';
$lang['edit_company_profile_full_name_label'] = 'Account Holder Name';
$lang['logout_confirm_title_label'] = 'Logout';
$lang['edit_company_profile_name'] = 'Company Name';
$lang['edit_company_profile_url'] = 'Company Link for Users';
$lang['edit_company_profile_primary_account_holder'] = 'Primary Account Holder';
$lang['edit_company_profile_general_email'] = 'Company General Email Address';
$lang['edit_company_profile_support_email'] = 'Company Support Email Address';
$lang['edit_company_profile_office_phone'] = 'Office Phone';
$lang['edit_company_profile_alternative_office_phone'] = 'Alternative Office Phone';
$lang['edit_company_profile_mailing_address'] = 'Mailing Address';
$lang['edit_company_profile_state'] = 'State';
$lang['edit_company_profile_zip_code'] = 'Zip Code';
$lang['edit_company_profile_website'] = 'Website';
$lang['edit_company_profile_fax_number'] = 'Fax Number';
$lang['edit_company_profile_company_logo'] = 'Company Logo';
$lang['edit_company_profile_secondary_company_logo'] = 'Secondary Company Logo';
$lang['edit_company_profile_secondary_company_logo_color1'] = 'Company Color 1';
$lang['edit_company_profile_secondary_company_logo_color2'] = 'Company Color 2';
$lang['edit_company_profile_secondary_company_logo_color3'] = 'Company Color 3';
$lang['edit_company_profile_secondary_company_logo_color4'] = 'Company Color 4';
$lang['edit_company_profile_license_number'] = 'License Numbers and/or Legal Disclaimers';
$lang['edit_company_profile_secondary_social_media'] = 'Social Media';
$lang['edit_company_profile_heading'] = 'Headline';
$lang['edit_company_profile_subheading'] = 'Sub-Headline';

// Mail Template Labels
$lang['mail_template_name_label'] = 'Template Name';
$lang['page_title_label'] = 'Page Title';
$lang['page_content_label'] = 'Page Content';
$lang['update_template_mail_button'] = 'Update Template';
$lang['update_page_content_button'] = 'Update Page';
$lang['mail_template_subject_label'] = 'Subject';
$lang['mail_template_content_label'] = 'Template Content';

// Membership package Labels
$lang['member_package_amount_label'] = 'Package Amount';
$lang['member_package_mode_label'] = 'Package Amount';
$lang['member_package_account_label'] = 'Package Mode';
$lang['update_member_package_button'] = 'Update Package';
$lang['membership_package_label'] = "Membership Package";

// Coupon Code Labels
$lang['coupon_code_label'] = "Coupon Code";
$lang['coupon_code_type_label'] = "Discount Type";
$lang['coupon_code_applicable_label'] = "Applicable On";
$lang['no_of_days_label'] = "Number Of Days";
$lang['percentage_label'] = "Percentage";
$lang['coupon_code_desc_label'] = "Description";
$lang['coupon_start_date_label'] = "Start Date";
$lang['coupon_end_date_label'] = "End Date";
$lang['coupon_code_mode_label'] = "Payment Mode";

$lang['add_college_label_button'] = "Add College";
$lang['update_college_label_button'] = "Update College";

// Edit User Profile
$lang['edit_user_profile_full_name_label'] = 'Full Name';

//manage states
$lang['state_label'] = 'State Name';
$lang['state_code_label'] = 'State Code';
$lang['update_state_button'] = 'Update State';
$lang['save_state_button'] = 'Save State';

//site settings
$lang['label_tax_percentage'] = "Tax Percentage";
$lang['label_time_zone'] = "Time Zone";
$lang['label_site_title'] = "Site Title";
$lang['edit_site_settings_btn'] = "Update Settings";

//manage video
$lang['title_label'] = 'Title';
$lang['url_label'] = 'Video Url';
$lang['update_video_button'] = 'Update Video';
$lang['save_video_button'] = 'Save Video';

$lang['affiliate_profile_paypal_email_label'] = 'Paypal Email Address';

$lang['update_user_submit_btn'] = 'Update Profile';

$lang['profile_update_provider'] = 'Provider profile successfully updated.';

$lang['profile_update_patient'] = 'Student profile successfully updated.';
