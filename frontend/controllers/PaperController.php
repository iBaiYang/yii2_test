<?php
namespace frontend\controllers;

use yii;
use yii\web\Controller;

class PaperController extends Controller
{
    /**
     * activity表
     */
    public function actionActivity()
    {
        $data_old = yii::$app->paper_old->createCommand('SELECT * FROM activity')
            ->queryAll();
        $total = 0;
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                Yii::$app->paper_new->createCommand()->insert('activity', [
                    'id' => $value['actId'],
                    'title' => $value['actTitle'],
                    'info' => $value['actCont'],
                    'status' => $value['Online'] == 1 ? 2 : 3,
                    'created_admin_id' => 1,
                    'created_at' => $this->transTime( $value['actTime'] ),
                    'updated_admin_id' => 1,
                    'updated_at' =>  $this->transTime( $value['actTime'] ),
                    'click_total' => $value['ClickTimes'],
                ])->execute();

                $total++;
            }
        }

        echo "转移".$total."条";
    }

    /**
     * base表
     */
    public function actionBase()
    {
        $data_old = yii::$app->paper_old->createCommand('SELECT * FROM base')
            ->queryAll();
        $total = 0;
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                Yii::$app->paper_new->createCommand()->insert('base_need', [
                    'id' => $value['BaseId'],
                    'title' => $value['BaTitle'],
                    'info' => $value['BaContent'],
                    'status' => $value['Online'] == 1 ? 1 : 2,
                    'created_admin_id' => 1,
                    'created_at' => $this->transTime( $value['AddTime'] ),
                    'updated_admin_id' => 1,
                    'updated_at' =>  $this->transTime( $value['AddTime'] ),
                    'click_total' => $value['ClickTimes'],
                ])->execute();

                if ( $value['BaAnnex1Name'] ) {
                    Yii::$app->paper_new->createCommand()->insert('base_need_file', [
                        'base_need_id' => $value['BaseId'],
                        'order_num' => 1,
                        'file_name' => $value['BaAnnex1Name'],
                        'file_addr' => $value['BaAnnex1Addr'],
                        'created_admin_id' => 1,
                        'created_at' => $this->transTime( $value['AddTime'] ),
                    ])->execute();
                }

                if ( $value['BaAnnex2Name'] ) {
                    Yii::$app->paper_new->createCommand()->insert('base_need_file', [
                        'base_need_id' => $value['BaseId'],
                        'order_num' => 2,
                        'file_name' => $value['BaAnnex2Name'],
                        'file_addr' => $value['BaAnnex2Addr'],
                        'created_admin_id' => 1,
                        'created_at' => $this->transTime( $value['AddTime'] ),
                    ])->execute();
                }

                if ( $value['BaAnnex3Name'] ) {
                    Yii::$app->paper_new->createCommand()->insert('base_need_file', [
                        'base_need_id' => $value['BaseId'],
                        'order_num' => 3,
                        'file_name' => $value['BaAnnex3Name'],
                        'file_addr' => $value['BaAnnex3Addr'],
                        'created_admin_id' => 1,
                        'created_at' => $this->transTime( $value['AddTime'] ),
                    ])->execute();
                }

                $total++;
            }
        }

        echo "转移".$total."条";
    }

    /**
     * huai表
     */
    public function actionHuai()
    {
        $data_old = yii::$app->paper_old->createCommand('SELECT * FROM huai')
            ->queryAll();
        $total = 0;
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                switch ( $value['ku'] )
                {
                    case 'paperinfo':
                        Yii::$app->paper_new->createCommand()->insert('report_paper', [
                            'pid' => $value['kuId'],
                            'cate' => $value['huaiCate'],
                            'info' => $value['huaiCont'],
                            'created_user_id' => $value['UserId'],
                            'created_at' => $this->transTime( $value['huaiTime'] ),
                        ])->execute();
                        break;
                    case 'PCom':
                        Yii::$app->paper_new->createCommand()->insert('report_paper_comment', [
                            'pid' => $value['kuId'],
                            'cate' => $value['huaiCate'],
                            'info' => $value['huaiCont'],
                            'created_user_id' => $value['UserId'],
                            'created_at' => $this->transTime( $value['huaiTime'] ),
                        ])->execute();
                        break;
                    case 'luntan_tiez':
                        Yii::$app->paper_new->createCommand()->insert('report_forum', [
                            'pid' => $value['kuId'],
                            'cate' => $value['huaiCate'],
                            'info' => $value['huaiCont'],
                            'created_user_id' => $value['UserId'],
                            'created_at' => $this->transTime( $value['huaiTime'] ),
                        ])->execute();
                        break;
                    case 'luntan_huif':
                        Yii::$app->paper_new->createCommand()->insert('report_forum_comment', [
                            'pid' => $value['kuId'],
                            'cate' => $value['huaiCate'],
                            'info' => $value['huaiCont'],
                            'created_user_id' => $value['UserId'],
                            'created_at' => $this->transTime( $value['huaiTime'] ),
                        ])->execute();
                        break;
                }

                $total++;
            }
        }

        echo "转移".$total."条";
    }

    /**
     * letter表
     */
    public function actionLetter()
    {
        $data_old = yii::$app->paper_old->createCommand('SELECT * FROM letter')
            ->queryAll();
        $total = 0;
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                Yii::$app->paper_new->createCommand()->insert('mailbox', [
                    'id' => $value['letterId'],
                    'info' => $value['letterCont'],
                    'created_user_id' => $value['UserId'],
                    'created_at' => $this->transTime( $value['letterTime'] ),
                ])->execute();

                $total++;
            }
        }

        echo "转移".$total."条";
    }

    /**
     * luntan_bank表
     */
    public function actionLuntanBank()
    {
        $data_old = yii::$app->paper_old->createCommand('SELECT * FROM luntan_bank')
            ->queryAll();
        $total = 0;
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                Yii::$app->paper_new->createCommand()->insert('forum_plate', [
                    'id' => $value['LunbId'],
                    'name' => $value['LunbName'],
                    'order_num' => $value['LunbId'],
                    'created_admin_id' => 1,
                    'created_at' => time(),
                    'updated_admin_id' => 1,
                    'updated_at' => time(),
                ])->execute();

                $total++;
            }
        }

        echo "转移".$total."条";
    }

    /**
     * luntan_tiez表
     */
    public function actionLuntanTiez()
    {
        $data_old = yii::$app->paper_old->createCommand('SELECT * FROM luntan_tiez')
            ->queryAll();
        $total = 0;
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                Yii::$app->paper_new->createCommand()->insert('forum', [
                    'id' => $value['LuntId'],
                    'pid' => $value['LuntCate'],
                    'title' => $value['LuntTitle'],
                    'info' => $value['LuntCon'],
                    'status' => $value['LuntOr'],
                    'created_user_id' => $value['UserId'],
                    'created_at' => $this->transTime( $value['LuntTime'] ),
                    'updated_user_id' => $value['UserId'],
                    'updated_at' => $this->transTime( $value['LuntTime'] ),
                ])->execute();

                $total++;
            }
        }

        echo "转移".$total."条";
    }

    /**
     * luntan_huif表
     */
    public function actionLuntanHuif()
    {
        $data_old = yii::$app->paper_old->createCommand('SELECT * FROM luntan_huif')
            ->queryAll();
        $total = 0;
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                if ( $value['LunthRel'] == 2 ) {
                    $floor_id = $this->getFloorFrist( $value['Lunth2R1'] );
                } else {
                    $floor_id = 0;
                }
                if ( !empty($value['LunthCon']) ) {
                    Yii::$app->paper_new->createCommand()->insert('forum_comment', [
                        'id' => $value['LunthId'],
                        'forum_id' => $value['LuntId'],
                        'floor_id' => $floor_id,
                        'parent_id' => $value['Lunth2R1'] ? $value['Lunth2R1'] : 0,
                        'be_user_id' => $value['UserIdB'] ? $value['UserIdB'] : 0,
                        'is_read' => $value['reador'],
                        'info' => $value['LunthCon'],
                        'status' => $value['LunthOr'],
                        'created_user_id' => $value['UserId2'],
                        'created_at' => $this->transTime( $value['LunthTime'] ),
                    ])->execute();
                }

                $total++;
            }
        }

        echo "转移".$total."条";
    }

    /**
     * notice表
     */
    public function actionNotice()
    {
        $data_old = yii::$app->paper_old->createCommand('SELECT * FROM notice')
            ->queryAll();
        $total = 0;
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                Yii::$app->paper_new->createCommand()->insert('notice', [
                    'id' => $value['noticeId'],
                    'title' => $value['notiTitle'],
                    'info' => $value['notiCont'],
                    'status' => $value['Online'] == 1 ? 2 : 3,
                    'created_admin_id' => 1,
                    'created_at' => $this->transTime( $value['notiTime'] ),
                    'updated_admin_id' => 1,
                    'updated_at' =>  $this->transTime( $value['notiTime'] ),
                    'click_total' => $value['ClickTimes'],
                ])->execute();

                $total++;
            }
        }

        echo "转移".$total."条";
    }

    /**
     * paperinfo表
     */
    public function actionPaperinfo()
    {
        $data_old = yii::$app->paper_old->createCommand('SELECT * FROM paperinfo')
            ->queryAll();
        $total = 0;
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                Yii::$app->paper_new->createCommand()->insert('paper', [
                    'id' => $value['PaperId'],
                    'cate_first' => $value['PCategory0'],
                    'cate_second' => $value['PCategory1'],
//                    'cate_third' => $value['PCategory2'],
//                    'cate_fourth' => $value['PCategory3'],
                    'title_ch' => $value['PTitleCh'],
                    'title_en' => $value['PTitleEn'],
                    'abstract_ch' => $value['PSummaryCh'],
                    'abstract_en' => $value['PSummaryEn'],
                    'keyword_ch' => $value['PKeywordCh'],
                    'keyword_en' => $value['PKeywordEn'],
                    'author_primary_ch' => $value['PWriter1Ch'],
                    'author_primary_en' => $value['PWriter1En'],
                    'author_other_ch' => $value['PWriter2Ch'],
                    'author_other_en' => $value['PWriter2En'],
                    'file_first_addr' => $value['Paper1Con'] ? $value['Paper1Con'] : '',
                    'file_revise_addr' => $value['PapernCon'] ? $value['PapernCon'] : '',
                    'status' => $value['PaperOr'] == 1 ? 1 : 0,
                    'created_user_id' => $value['UserId'],
                    'created_at' => $this->transTime( $value['PaperTime'] ),
                    'updated_user_id' => $value['UserId'],
                    'updated_at' =>  $value['PapernTime'] ? $this->transTime( $value['PapernTime'] ) : $this->transTime( $value['PaperTime'] ),
                    'click_total' => $value['PClickTime'],
                    'download_total' => $value['PDownLoad'],
                ])->execute();

                if ( !empty($value['PRefDoc1']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 1,
                        'info' => $value['PRefDoc1'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc2']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 2,
                        'info' => $value['PRefDoc2'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc3']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 3,
                        'info' => $value['PRefDoc3'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc4']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 4,
                        'info' => $value['PRefDoc4'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc5']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 5,
                        'info' => $value['PRefDoc5'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc6']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 6,
                        'info' => $value['PRefDoc6'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc7']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 7,
                        'info' => $value['PRefDoc7'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc8']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 8,
                        'info' => $value['PRefDoc8'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc9']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 9,
                        'info' => $value['PRefDoc9'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc10']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 10,
                        'info' => $value['PRefDoc10'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc11']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 11,
                        'info' => $value['PRefDoc11'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc12']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 12,
                        'info' => $value['PRefDoc12'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc13']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 13,
                        'info' => $value['PRefDoc13'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc14']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 14,
                        'info' => $value['PRefDoc14'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc15']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 15,
                        'info' => $value['PRefDoc15'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc16']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 16,
                        'info' => $value['PRefDoc16'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc17']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 17,
                        'info' => $value['PRefDoc17'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc18']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 18,
                        'info' => $value['PRefDoc18'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc19']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 19,
                        'info' => $value['PRefDoc19'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc20']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 20,
                        'info' => $value['PRefDoc20'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }
                if ( !empty($value['PRefDoc21']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_reference', [
                        'pid' => $value['PaperId'],
                        'order_num' => 21,
                        'info' => $value['PRefDoc21'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PaperTime'] ),
                    ])->execute();
                }

                $total++;
            }
        }

        echo "转移".$total."条";
    }

    /**
     * paperzan表
     */
    public function actionPaperzan()
    {
        $data_old = yii::$app->paper_old->createCommand('SELECT * FROM paperzan')
            ->queryAll();
        $total = 0;
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                Yii::$app->paper_new->createCommand()->insert('paper_praise', [
                    'id' => $value['zanId'],
                    'pid' => $value['PaperId'],
                    'created_user_id' => $value['userId'],
                    'created_at' => strtotime('2015-08-01 10:10:10'),
                ])->execute();

                $total++;
            }
        }

        echo "转移".$total."条";
    }

    /**
     * pcate0表
     */
    public function actionPcate0()
    {
        $data_old = yii::$app->paper_old->createCommand('SELECT * FROM pcate0')
            ->queryAll();
        $total = 0;
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                Yii::$app->paper_new->createCommand()->insert('paper_category', [
                    'type' => 1,
                    'num' => $value['PCate0Id'],
                    'name' => $value['PCate0Name'],
                    'created_admin_id' => 1,
                    'created_at' => strtotime('2013-10-01 10:10:10'),
                    'updated_admin_id' => 1,
                    'updated_at' => strtotime('2013-10-01 10:10:10'),
                ])->execute();

                $total++;
            }
        }

        echo "转移".$total."条";
    }

    /**
     * pcate1表
     */
    public function actionPcate1()
    {
        $data_old = yii::$app->paper_old->createCommand('SELECT * FROM pcate1')
            ->queryAll();
        $total = 0;
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                Yii::$app->paper_new->createCommand()->insert('paper_category', [
                    'type' => 2,
                    'pnum' => $value['PCate0Id'],
                    'num' => $value['PCate1Id'],
                    'name' => $value['PCate1Name'],
                    'created_admin_id' => 1,
                    'created_at' => strtotime('2013-10-01 10:10:10'),
                    'updated_admin_id' => 1,
                    'updated_at' => strtotime('2013-10-01 10:10:10'),
                ])->execute();

                $total++;
            }
        }

        echo "转移".$total."条";
    }

    /**
     * pcate2表
     */
    public function actionPcate2()
    {
        $data_old = yii::$app->paper_old->createCommand('SELECT * FROM pcate2')
            ->queryAll();
        $total = 0;
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                Yii::$app->paper_new->createCommand()->insert('paper_category', [
                    'type' => 3,
                    'pnum' => $value['PCate1Id'],
                    'num' => $value['PCate2Id'],
                    'name' => $value['PCate2Name'],
                    'created_admin_id' => 1,
                    'created_at' => strtotime('2013-10-01 10:10:10'),
                    'updated_admin_id' => 1,
                    'updated_at' => strtotime('2013-10-01 10:10:10'),
                ])->execute();

                $total++;
            }
        }

        echo "转移".$total."条";
    }

    /**
     * pcate3表
     */
    public function actionPcate3()
    {
        $data_old = yii::$app->paper_old->createCommand('SELECT * FROM pcate3')
            ->queryAll();
        $total = 0;
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                Yii::$app->paper_new->createCommand()->insert('paper_category', [
                    'type' => 4,
                    'pnum' => $value['PCate2Id'],
                    'num' => $value['PCate3Id'],
                    'name' => $value['PCate3Name'],
                    'created_admin_id' => 1,
                    'created_at' => strtotime('2013-10-01 10:10:10'),
                    'updated_admin_id' => 1,
                    'updated_at' => strtotime('2013-10-01 10:10:10'),
                ])->execute();

                $total++;
            }
        }

        echo "转移".$total."条";
    }

    /**
     * pcom表
     */
    public function actionPcom()
    {
        $data_old = yii::$app->paper_old->createCommand('SELECT * FROM pcom')
            ->queryAll();
        $total = 0;
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                if ( $value['PCGRel'] == 2 ) {
                    $floor_id = $this->getPCFloorFrist( $value['PCGId2'] );
                } else {
                    $floor_id = 0;
                }
                if ( !empty($value['PCGCons']) ) {
                    Yii::$app->paper_new->createCommand()->insert('paper_comment', [
                        'id' => $value['PCGId'],
                        'paper_id' => $value['PaperId'],
                        'floor_id' => $floor_id,
                        'parent_id' => $value['PCGId2'] ? $value['PCGId2'] : 0,
                        'be_user_id' => $value['UserIdB'] ? $value['UserIdB'] : 0,
                        'is_read' => $value['reador'],
                        'info' => $value['PCGCons'],
                        'status' => $value['PCOr'],
                        'created_user_id' => $value['UserId'],
                        'created_at' => $this->transTime( $value['PCGTime'] ),
                    ])->execute();
                }

                $total++;
            }
        }

        echo "转移".$total."条";
    }

    /**
     * user相关表
     */
    public function actionUser()
    {
        $sql = 'SELECT * FROM userlog as a Left join userinfo as b On a.UserID = b.UserId ';
        $data_old = yii::$app->paper_old->createCommand( $sql )
            ->queryAll();
        $total = 0;
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                if ( $value['Status'] == 1 ) {
                    Yii::$app->paper_new->createCommand()->insert('user', [
                        'id' => $value['UserID'],
                        'username' => $value['UserEmail'],
                        'nickname' => $value['UserNikeName'] ? $value['UserNikeName'] : '',
                        'email' => $value['UserEmail'],
                        'auth_key' => 'PWKMyyRmZOkKKD',
                        'password_hash' => 'PWKMyyRmZOkKKD',
                        'status' => 1,
                        'created_at' => $this->transTime( $value['TimeLog'] ),
                        'updated_at' => $value['LoginLast'] ? $this->transTime( $value['LoginLast'] ) : $this->transTime( $value['TimeLog'] ),
                    ])->execute();
                    Yii::$app->paper_new->createCommand()->insert('user_info', [
                        'user_id' => $value['UserID'],
                        'truename' => $value['UserNameTrue'] ? $value['UserNameTrue'] : '',
                        'sex' => $value['UserSex'] == 1 ? 0 :1,
                        'birthday' => $value['UserBirthday'] ? $this->transTime( $value['UserBirthday'] ) : '',
                        'created_at' => $this->transTime( $value['TimeLog'] ),
                        'updated_at' => $value['LoginLast'] ? $this->transTime( $value['LoginLast'] ) : $this->transTime( $value['TimeLog'] ),
                    ])->execute();
                    if ( !empty($value['IPLogin']) ) {
                        Yii::$app->paper_new->createCommand()->insert('log_user_login', [
                            'user_id' => $value['UserID'],
                            'ip' => $value['IPLogin'],
                            'created_at' => $value['TimeLog'] ? $this->transTime( $value['TimeLog'] ) :'',
                        ])->execute();
                    }
                    if ( !empty($value['IPLast']) ) {
                        Yii::$app->paper_new->createCommand()->insert('log_user_login', [
                            'user_id' => $value['UserID'],
                            'ip' => $value['IPLast'],
                            'created_at' => $value['LoginLast'] ? $this->transTime( $value['LoginLast'] ) : '',
                        ])->execute();
                    }
                }

                $total++;
            }
        }

        echo "转移".$total."条";
    }

    /**
     * 获取楼层的评论id
     * @param $id
     * @return mixed
     */
    protected function getFloorFrist( $id )
    {
        $data_old = yii::$app->paper_old->createCommand('SELECT * FROM luntan_huif WHERE LunthId ='.$id )
            ->queryOne();
        if ( $data_old['LunthRel'] == 2 ) {
            return $this->getFloorFrist( $data_old['Lunth2R1'] );
        } else {
            return $data_old['LunthId'];
        }
    }

    /**
     * 获取论文评论楼层的评论id
     * @param $id
     * @return mixed
     */
    protected function getPCFloorFrist( $id )
    {
        $data_old = yii::$app->paper_old->createCommand('SELECT * FROM pcom WHERE PCGId ='.$id )
            ->queryOne();
        if ( $data_old['PCGRel'] == 2 ) {
            return $this->getPCFloorFrist( $data_old['PCGId2'] );
        } else {
            return $data_old['PCGId'];
        }
    }

    /**
     * 时间转化为时间戳
     * @param $date
     * @return string
     */
    protected function transTime( $date )
    {
        $time = '';
        if ( !empty($date) ) {
            $data_arr = explode('T', $date);
            $time = strtotime( $data_arr['0']." ".$data_arr['1']);
        }

        return $time;
    }

    /**
     * 举报记录表
     */
    public function actionReport()
    {
        $total = 0;

        $data_old = yii::$app->paper_new->createCommand('SELECT * FROM report_paper')
            ->queryAll();
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                Yii::$app->paper_new->createCommand()->insert('report', [
                    'type' => 1,
                    'pid' => $value['pid'],
                    'cate' => $value['cate'],
                    'info' => $value['info'],
                    'created_user_id' => $value['created_user_id'],
                    'created_at' => $value['created_at'],
                ])->execute();

                $total++;
            }
        }
        $data_old = yii::$app->paper_new->createCommand('SELECT * FROM report_paper_comment')
            ->queryAll();
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                Yii::$app->paper_new->createCommand()->insert('report', [
                    'type' => 2,
                    'pid' => $value['pid'],
                    'cate' => $value['cate'],
                    'info' => $value['info'],
                    'created_user_id' => $value['created_user_id'],
                    'created_at' => $value['created_at'],
                ])->execute();

                $total++;
            }
        }
        $data_old = yii::$app->paper_new->createCommand('SELECT * FROM report_forum')
            ->queryAll();
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                Yii::$app->paper_new->createCommand()->insert('report', [
                    'type' => 3,
                    'pid' => $value['pid'],
                    'cate' => $value['cate'],
                    'info' => $value['info'],
                    'created_user_id' => $value['created_user_id'],
                    'created_at' => $value['created_at'],
                ])->execute();

                $total++;
            }
        }
        $data_old = yii::$app->paper_new->createCommand('SELECT * FROM report_forum_comment')
            ->queryAll();
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                Yii::$app->paper_new->createCommand()->insert('report', [
                    'type' => 4,
                    'pid' => $value['pid'],
                    'cate' => $value['cate'],
                    'info' => $value['info'],
                    'created_user_id' => $value['created_user_id'],
                    'created_at' => $value['created_at'],
                ])->execute();

                $total++;
            }
        }

        echo "转移".$total."条";
    }

    /**
     * 更新论文的分类
     */
    public function actionPaperOfCateUpdate()
    {
        $total = 0;

        $data_old = yii::$app->paper_dev->createCommand('SELECT * FROM paper')
            ->queryAll();
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                if ( $value['cate_first'] ) {
                    $cate_first = yii::$app->paper_dev->createCommand("SELECT id FROM paper_category WHERE num = '".$value['cate_first']."'")
                        ->queryScalar();
                    $cate_second = yii::$app->paper_dev->createCommand("SELECT id FROM paper_category WHERE num = '".$value['cate_second']."'")
                        ->queryScalar();
                    yii::$app->paper_dev->createCommand()->update('paper', [
                            'cate_first' => $cate_first,
                            'cate_second' => $cate_second,
                        ],
                        "id = :id", array( ':id' => $value['id'] )
                    )->execute();
                }

                $total++;
            }
        }

        echo "更新".$total."条";
    }

    /**
     * 更新论文分类
     */
    public function actionPaperCateUpdate()
    {
        $total = 0;

        $data_old = yii::$app->paper_dev->createCommand('SELECT * FROM paper_category')
            ->queryAll();
        if ( !empty($data_old) ) {
            foreach ( $data_old as $key => $value )
            {
                if ( $value['pnum'] ) {
                    $pid = yii::$app->paper_dev->createCommand("SELECT id FROM paper_category WHERE num = '".$value['pnum']."'")
                        ->queryScalar();
                    yii::$app->paper_dev->createCommand()->update('paper_category', [
                        'pid' => $pid,
                    ],
                        "id = :id", array( ':id' => $value['id'] )
                    )->execute();
                }

                $total++;
            }
        }

        echo "更新".$total."条";
    }

}