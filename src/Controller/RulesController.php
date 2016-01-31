<?php

/**
 * @file
 * Rules controller.
 */

namespace Drupal\rules\Controller;

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
  public function autocomplete(Request $request, $mode, $context) {
    $matches = array();
    $string = $request->query->get('q');
    $roles = user_roles();
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
