<?php namespace Kirschbaum\DrupalBehatRemoteAPIDriver;

interface CustomFormatterInterface {

    /**
     * Process custom Drupal data formats
     *
     * TODO Better comments, and consider better way of handling this data.
     * @param $info The field info for the current field in question.
     * @param $new_entity The node object being built up and formatted prior to the request.
     * @param $param The field machine name.
     * @param $column The first defined column for the field in question.
     * @param $value The value for the field in question.
     * @param $custom_data_tables Array of table objects added by custom steps.
     * @return Response The updated node object.
     */
    public function process($info, $new_entity, $param, $column, $value, $custom_data_tables);

}