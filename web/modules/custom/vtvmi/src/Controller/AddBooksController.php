<?php

namespace Drupal\vtvmi\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class AddBooksController.
 */
class AddBooksController extends ControllerBase {

  /**
   * Build.
   *
   * @return string
   *   Return Hello string.
   */
  public function build() {



    // @todo clean url.
    $uri = 'http://vtv6.dvmwk.kem/boe_tools/book-structure.json';
    try {
      $response = \Drupal::httpClient()
          ->get($uri, array('headers' => array('Accept' => 'text/plain')));
      $data = (string) $response->getBody();
      $data = json_decode($data);


      if (empty($data)) {
        return FALSE;
      }
      else {
        foreach ($data as $datum) {
          $nid = _vtvmi_migrate_get_local_nid($datum->nid);
          if ($datum->pid > 0) {
            $pid = _vtvmi_migrate_get_local_nid($datum->pid);
          }
          elseif ($datum->pid == 0 || is_null($datum->pid)) {
            $pid = 0;
          }
          $bid = _vtvmi_migrate_get_local_nid($datum->bid);
          if ($nid && $bid && $pid >= 0) {
            $query = \Drupal::database()->upsert('book');
            $query->fields([
                'nid',
                'bid',
                'pid',
                'has_children',
                'weight',
                'depth',
                'p1',
                'p2',
                'p3',
                'p4',
                'p5',
                'p6',
                'p7',
                'p8',
                'p9',
            ]);
            $query->values([
                $nid,
                $bid,
                $pid,
                $datum->has_children,
                $datum->weight,
                $datum->depth,
                $datum->p1 > 0 ? _vtvmi_migrate_get_local_nid($datum->p1) : 0,
                $datum->p2 > 0 ? _vtvmi_migrate_get_local_nid($datum->p2) : 0,
                $datum->p3 > 0 ? _vtvmi_migrate_get_local_nid($datum->p3) : 0,
                $datum->p4 > 0 ? _vtvmi_migrate_get_local_nid($datum->p4) : 0,
                $datum->p5 > 0 ? _vtvmi_migrate_get_local_nid($datum->p5) : 0,
                $datum->p6 > 0 ? _vtvmi_migrate_get_local_nid($datum->p6) : 0,
                $datum->p7 > 0 ? _vtvmi_migrate_get_local_nid($datum->p7) : 0,
                $datum->p8 > 0 ? _vtvmi_migrate_get_local_nid($datum->p8) : 0,
                $datum->p9 > 0 ? _vtvmi_migrate_get_local_nid($datum->p9) : 0,
            ]);
            $query->key('nid');
            $query->execute();
          }
        }
      }
    }
    catch (RequestException $e) {
      echo $e;
      return FALSE;
    }

















    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: build')
    ];
  }

}
