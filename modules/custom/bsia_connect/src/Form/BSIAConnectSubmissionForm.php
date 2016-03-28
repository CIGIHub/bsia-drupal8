<?php
/**
 * @file
 * Contains \Drupal\bsia_connect\Form\BSIAConnectSubmissionForm.
 */

namespace Drupal\bsia_connect\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * BSIA Connect with us form.
 */
class BSIAConnectSubmissionForm extends FormBase {

	/**
	 * {@inheritdoc}
	 */
	public function getFormID() {
		return 'bsia_connect_form';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getEditableConfigNames() {
		return ['bsia_connect.settings'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(array $form, FormStateInterface $form_state) {
		$config = $this->config('bsia_connect.settings');

		$form['form-options'] = array(
		  '#type' => 'container',
		  '#attributes' => array(
		    'class' => 'form-options',
		  ),
		);
		$form['form-options']['bsia_connect_title'] = array(
			'#type' => 'item',
			'#markup' => "<h3>How would you like to connect with us? (Select all that apply)</h3>",
		);

		$form['form-options']['programs'] = array(
			'#type' => 'checkboxes',
			'#options' => array(
				"phd" => t('PhD in Global Governance'),
				"magg" => t('Master of Arts in Global Governance (MAGG)'),
				"mipp" => t('Master of International Public Policy (MIPP)'),
			),
			'#title' => $this->t('Find out more about our programs?'),
		);

		$form['form-options']['weekly_bulletin'] = array(
			'#type' => 'checkbox',
			'#title' => $this->t('Sign up for our weekly bulletin to learn about upcoming events and opportunities.'),
		);

		$form['form-options']['campus_tour'] = array(
			'#type' => 'checkbox',
			'#title' => $this->t('Book a tour of our campus.'),
		);

		$form['form-contact'] = array(
		  '#type' => 'container',
		  '#attributes' => array(
		    'class' => 'contact-info',
		  ),
		);
		$form['form-contact']['contact_title'] = array(
			'#type' => 'item',
			'#markup' => "Please provide us with your email address and name so we can connect with you.",
		);

		$form['form-contact']['first_name'] = array(
			'#type' => 'textfield',
			'#title' => t('First Name'),
			'#placeholder' => t("First Name"),
			'#size' => 60,
			'#maxlength' => 128,
		);

		$form['form-contact']['last_name'] = array(
			'#type' => 'textfield',
			'#title' => t('Last Name'),
			'#placeholder' => t("Last Name"),
			'#size' => 60,
			'#maxlength' => 128,
		);


		$form['form-contact']['email'] = array(
			'#type' => 'email',
			'#title' => t('Email'),
			'#placeholder' => t("Email Address (Required)"),
			'#size' => 60,
			'#maxlength' => 128,
			'#required' => true,
		);
		
		//$form['actions'] = array('#type' => 'actions');
		$form['form-contact']['submit'] = array(
			'#type' => 'submit',
			'#value' => $this->t('Sign Up'),
			'#button_type' => 'primary',
		);


		return $form;
	}

	/**
	 * {@inheritdoc}
	 */
	public function submitForm(array &$form, FormStateInterface $form_state) {

		drupal_set_message(t("Thank you for connecting with us. A Program Director will respond to your request shortly."), 'status', FALSE);
		$programs = $form_state->getValue('programs');
		$newsletter = $form_state->getValue('weekly_bulletin');
		$campus_tour = $form_state->getValue('campus_tour');

		if (!empty($newsletter)) {
			self::sendNewsletter($form_state);
		}

		self::sendMail($form_state);
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateForm(array &$form, FormStateInterface $form_state) {
		$programs = $form_state->getValue('programs');
		$weekly_bulletin = $form_state->getValue('weekly_bulletin');
		$campus_tour = $form_state->getValue('campus_tour');

		$optionSelected = false;
		//programs are checkboxes, either a 0 or the key.
		foreach ($programs as $key => $value) {
			if (!empty($value)) {
				$optionSelected = true;
				break;
			}
		}

		if (!$optionSelected && empty($weekly_bulletin) && empty($campus_tour)) {
			$form_state->setErrorByName('bsia_connect_title', $this->t("You must select at least one option!"));
		}
	}
	private function sendNewsletter(FormStateInterface $form_state) {

		$logger = \Drupal::logger('bsia_connect');
		$logger->notice(t("Sending Newsletter..."));

		$url = 'https://app.icontact.com/icp/signup.php';
		$data = array('fields_email' => $form_state->getValue('email'),
			'fields_fname' => $form_state->getValue('first_name'),
			'fields_lname' => $form_state->getValue('last_name'),
			'listid' => "5679",
			'specialid:5679' => "S462",
			'clientid' => "1183285",
			'formid' => "1064",
			'reallistid' => "1",
			'doubleopt' => "0",
			'redirect' => urlencode('http://www.icontact.com/www/signup/thanks.html'),
			'errorredirect' => urlencode('http://www.icontact.com/www/signup/error.html'));

		foreach ($data as $key => $value) {
			$post_items[] = $key . '=' . $value;
		}

		$fields_string = implode('&', $post_items);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($data));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

		$response = curl_exec($ch);
		curl_close($ch);

		$logger->notice(t("...Newletter Sent! Response:" . $response));
	}

	private function sendMail(FormStateInterface $form_state) {

		$reply = null;
		$langcode = 'en';
		$send = true;
		$to = 'info@balsillieschool.ca';
		$bcc = 'websiteupdates@balsillieschool.ca';
		$email_address = $form_state->getValue('email');

		\Drupal::service('plugin.manager.mail')->mail('bsia_connect', 'new_signup', $to, $langcode, $form_state->getValues(), $reply, $send);
		\Drupal::service('plugin.manager.mail')->mail('bsia_connect', 'new_signup', $bcc, $langcode, $form_state->getValues(), $reply, $send);
		\Drupal::service('plugin.manager.mail')->mail('bsia_connect', 'confirmation', $email_address, $langcode, $form_state->getValues(), $reply, $send);
	}
}
