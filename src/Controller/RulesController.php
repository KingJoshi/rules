<?php

/**
 * @file
 * Rules controller.
 */

namespace Drupal\rules\Controller;

use Drupal\Core\Form\FormState;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Utility\Html;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Returns responses for Rules routes.
 */
class RulesController extends ControllerBase {
  /**
   * Returns the settings page.
   *
   * @return array
   *   Renderable array.
   */
  public function settingsForm() {
    $element = [
      '#markup' => 'Rules settings form is not implemented yet.',
    ];
    return $element;
  }

  /**
   * Menu callback for Rules Conditions autocompletion.
   *
   * Like other autocomplete functions, this function inspects the 'q' query
   * parameter for the string to use to search for suggestions.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   A JSON response containing the autocomplete suggestions for RulesConditions.
   */
  public function autocomplete(Request $request, $mode, $context, $form_build_id) {
    /*
     * When on page url:
     *   admin/config/workflow/rules/reactions/edit/test_rule/add/rules_condition
     * Currently submits fields received as parameters by this function
     *
     * Form data submitted during autocomplete in Drupal 7 Rules
     *   context[user][setting]:
     *   context[roles][setting]:
     *   context_roles:Switch to data selection
     *   context[operation][setting]:AND
     *   form_build_id:form-iPYfsUouPfpLkBtwM9m0fLGqwFb0zXlXQYOg9Iu5b2U
     *   form_token:myg63S4Rg7xeaX2kGkZGFimzZ0Icyq0SH4qePkybMrQ
     *   form_id:rules_expression_add
     */
    $matches = array();
    $string = $request->query->get('q');
    $roles = user_roles();
    $form_state = new FormState();
    $form = \Drupal::formBuilder()->getCache($form_build_id, $form_state); // Code returns empty form
    foreach ($roles as $role) {
      $role_label = $role->label();
      if (stripos($role_label, $string) === 0) {
        $matches[] = ['value' => $role_label . " | $mode", 'label' => Html::escape($role_label) . " | $context"];
        if (count($matches) >= 10) {
          break;
        }
      }
    }

    return new JsonResponse($matches);
  }
}
