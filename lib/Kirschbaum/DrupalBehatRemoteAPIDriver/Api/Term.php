<?php namespace Kirschbaum\DrupalBehatRemoteAPIDriver\Api;


use Kirschbaum\DrupalBehatRemoteAPIDriver\Exception\DrupalResponseException;
use Kirschbaum\DrupalBehatRemoteAPIDriver\Exception\RuntimeException;

class Term extends BaseDrupalRemoteAPI {

    protected $remote_vocabularies;

    public function termCreate(\stdClass $term) {

        $this->getAndSetRemoteVocabularies();
        $term = $this->setVIDBasedOnRemoteVocabularyName($term);
        $term = $this->setVIDBasedOnRemoteVocabularyMachineName($term);
        $term = $this->ifParentExistsGetTermOfVocab($term);
        $this->confirmVocabulariesWasFound($term);
        $term = $this->transformOutgoingDataForRestWS($term);
        $result = $this->post('/taxonomy_term', (array) $term);
        $this->confirmResponseStatusCodeIs200($result);
        $term->tid = $result['id'];
        return (object) $term;
    }

    public function termDelete(\stdClass $term) {
        $result = $this->delete('/taxonomy_term/'.$term->tid);
        $this->confirmDeletedResponse($result);
    }

    private function getAndSetRemoteVocabularies()
    {
        $response = $this->get('/taxonomy_vocabulary.json');
        $this->confirmVocabulariesInWebserviceResponse($response);
        $this->remote_vocabularies = $response['list'];
    }

    private function confirmVocabulariesInWebserviceResponse($response)
    {
        if(!isset($response['list']) || count($response['list']) < 1)
        {
            throw new DrupalResponseException(sprintf('Remote API Exception: Response did not include vocabularies: %s', $response));
        }
    }

    private function setVIDBasedOnRemoteVocabularyName(\stdClass $term)
    {
        if (!isset($term->vid)) {
            foreach ($this->remote_vocabularies as $vid => $vocabulary) {
                if ($vocabulary['name'] == $term->vocabulary_machine_name) {
                    $term->vid = $vocabulary['vid'];
                }
            }
        }
        return $term;
    }

    private function setVIDBasedOnRemoteVocabularyMachineName($term)
    {
        if (!isset($term->vid)) {
            foreach ($this->remote_vocabularies as $vid => $vocabulary) {
                if ($vocabulary['machine_name'] == $term->vocabulary_machine_name) {
                    $term->vid = $vocabulary['vid'];
                }
            }
        }
        return $term;
    }

    private function transformOutgoingDataForRestWS($term)
    {
        $term->vocabulary = array('id' => $term->vid);
        unset($term->vid);
        unset($term->vocabulary_machine_name);
        return $term;
    }

    // @TODO Parent support needs to be implemented.
    private function ifParentExistsGetTermOfVocab($term)
    {
        // If `parent` is set, look up a term in this vocab with that name.
        if (isset($term->parent)) {
            throw new RuntimeException("Parent support for terms not currently implemented.");
            // $parent = \taxonomy_get_term_by_name($term->parent, $term->vocabulary_machine_name);
            // if (!empty($parent)) {
            //     $parent = reset($parent);
            //     $term->parent = $parent->tid;
            // }
        }
        return $term;
    }

    private function confirmVocabulariesWasFound($term)
    {
        if (empty($term->vid)) {
            throw new RuntimeException(sprintf('No "%s" vocabulary found.', $term->name));
        }
    }

    // @TODO Look more into moving this to RestWS instead of custom API.
    public function getTermsMetadata($terms)
    {
        $response = $this->get('/drupal-remote-api/terms/'.$terms);
        $this->confirmResponseStatusCodeIs200($response);
        return $response['data'];
    }


}