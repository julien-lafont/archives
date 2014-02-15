<?php

/**
 * Returns <script> tags for all javascripts configured in view.yml or added to the response object.
 *
 * You can use this helper to decide the location of javascripts in pages.
 * By default, if you don't call this helper, symfony will automatically include javascripts before </head>.
 * Calling this helper disables this behavior.
 *
 * @return string <script> tags
 */
function get_javascripts_by_position($position)
{
  $response = sfContext::getInstance()->getResponse();
  sfConfig::set('symfony.asset.javascripts_included', true);

  $html = '';
  foreach ($response->getJavascripts($position) as $file => $options)
  {
    $html .= javascript_include_tag($file, $options);
  }

  return $html;
}

/**
 * Prints <script> tags for all javascripts configured in view.yml or added to the response object.
 *
 * @see get_javascripts()
 */
function include_javascripts_by_position($position)
{
  echo get_javascripts_by_position($position);
}