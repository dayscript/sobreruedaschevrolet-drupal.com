<?php

function _sobre_ruedas_redeem_benefit($nid, $uid){
    $user = user_load($uid);
    $node = node_load($nid);

    $alias = drupal_get_path_alias('node/'.$node->nid);

    $query = new EntityFieldQuery();
    $query->entityCondition('entity_type', 'node')
        ->entityCondition('bundle', 'redemption')
        ->propertyCondition('uid', $user->uid)
        ->fieldCondition('field_benefits', 'target_id', $node->nid);

    $result = $query->execute();

    // if the benefit already exists, then skip the process
    if (isset($result['node'])) {
        drupal_set_message(t('The benefit is already redeemed.'));

    }else{ // if no exists, prepare for authorization logic

        $authorize = _sobre_ruedas_authorize_redemption($user, $node);

        if($authorize){
            $values = array(
                'type' => 'redemption',
                'uid' => $user->uid,
                'status' => 1,
                'comment' => 0,
                'promote' => 0,
            );

            // create initial node and instance wrapper
            $entity = entity_create('node', $values);
            $wrapper = entity_metadata_wrapper('node', $entity);

            // set values of node
            $wrapper->title->set('Redención del beneficio: '.$node->title." Usuario: ". $user->name);
            $wrapper->field_benefits->set(intval($node->nid));
            $wrapper->field_status->set('redemeed');

            // save the node in database
            $wrapper->save();

            drupal_set_message(t('The benefit has been successfully redeemed.'));
        }else{
            drupal_set_message(t('Unauthorized.'));                
        }
    }

    // go to benefit node path
    drupal_goto($alias);
}

function _sobre_ruedas_authorize_redemption($user, $node){
    $authorize = FALSE;
    //get benefit and user segments
    $segment_user = field_get_items('user', $user, 'field_segment');
    $segments_node = field_get_items('node', $node, 'field_segment');

    //check if node and user has a segment
    if($segment_user && $segments_node){
        //if the benefit's segment is equal to user's segment, then authorize to redeem
        foreach ($segments_node as $segment) {
            if($segment_user[0]['tid'] == $segment['tid']){
                $authorize = TRUE;
                break;
            }
        }

        // get the user's segment tree
        $term = taxonomy_term_load($segment_user[0]['tid']); 
        $term_tree = taxonomy_get_tree($term->vid, $term->tid);

        //if the benefit's segment is below user's segment, then authorize to redeem
        foreach ($term_tree as $term) {
            foreach ($segments_node as $segment) {
                if($term->tid == $segment['tid']){
                    $authorize = TRUE;
                    break 2;
                }
            }
        }
    }

    return $authorize;
}

function _sobre_ruedas_is_surprise_benefit($user, $node){
    $is_surprise = field_get_items('node', $node, 'field_is_surprise_benefit');

    $query = new EntityFieldQuery();
    $query->entityCondition('entity_type', 'node')
        ->entityCondition('bundle', 'redemption')
        ->propertyCondition('uid', $user->uid)
        ->fieldCondition('field_benefits', 'target_id', $node->nid);

    $result = $query->execute();

    if($node->type == 'benefit' && $is_surprise && $is_surprise[0]['value'] == 1 && !isset($result['node'])){
      return TRUE;
    }

    return FALSE;
}