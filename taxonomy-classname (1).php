<?php
/**
 * タクソノミーアーカイブテンプレート
 * すべてのタクソノミーアーカイブページに適用されます
 */
get_header();

// 現在のタクソノミー情報を取得
$term = get_queried_object();
$taxonomy = get_taxonomy($term->taxonomy);
?>
<!DOCTYPE html>

<style>
.recruitment-header-banner {
    background: linear-gradient(135deg, #ffd966, #f6b73c);
    height: 80px;
    width: 100vw;
    margin-left: calc(50% - 50vw);
    margin-right: calc(50% - 50vw);
}

.recruitment-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    background-color: #fff;
    min-height: calc(100vh - 80px);
}

.recruitment-main-title {
    text-align: center;
    font-size: 28px;
    font-weight: bold;
    color: #333;
    margin-bottom: 50px;
    letter-spacing: 1px;
}

.recruitment-intro-text {
    text-align: center;
    margin: 60px;
    line-height: 1.8;
}

.recruitment-company-name {
    font-weight: bold;
    color: #333;
}

.recruitment-info-section {
    margin-bottom: 60px;
}

.recruitment-info-row {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.recruitment-info-label {
    color: #f6b73c;
    font-weight: bold;
    min-width: 120px;
    margin-right: 20px;
}

.recruitment-info-value {
    color: #333;
}

.recruitment-info-value a {
    color: #333;
    text-decoration: none;
}

.recruitment-info-value a:hover {
    text-decoration: underline;
}

.recruitment-section-title {
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
    position: relative;
}

.recruitment-section-title::after {
    content: '';
    display: block;
    width: 60px;
    height: 4px;
    background-color: #f6b73c;
    margin: 15px auto 0;
}



/* タブスタイル - ZOZOTOWN風 */
.job-tabs {
    display: flex;
    justify-content: space-around;
    gap: 0;
    margin-bottom: 0;
    border-bottom: 2px solid #e0e0e0;
}

.job-tab {
    padding: 15px 10px;
    background: transparent;
    border: none;
    border-bottom: 3px solid transparent;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    color: #999;
    transition: all 0.3s ease;
    position: relative;
    flex: 1;
    text-align: center;
    line-height: 1.4;
}

.job-tab.hidden {
    display: none;
}

.job-tab:hover {
    color: #333;
}

.job-tab.active {
    color: #333;
    border-bottom-color: #f6b73c;
}

.job-tab-count {
    display: block;
    margin-top: 6px;
    font-size: 16px;
    font-weight: normal;
    color: #999;
}

.job-tab.active .job-tab-count {
    color: #f6b73c;
}

/* タブコンテンツ */
.job-tab-content {
    display: none;
    padding: 30px 0 0;
    background: #fff;
}

.job-tab-content.active {
    display: block;
}

/* 求人コンテナ */
.job-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 25px;
    margin-bottom: 60px;
    justify-items: center;
}

/* アコーディオン制御 */

.job-container .jo-card.hidden-card {
    display: none;
}

/* もっと見るボタン */
.show-more-container {
    text-align: center;
    margin-top: 30px;
    margin-bottom: 60px;
}

.show-more-btn {
    padding: 12px 40px;
    background-color: #f6b73c;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.show-more-btn:hover {
    background-color: #e5a62b;
}

.show-more-btn.hidden {
    display: none;
}

/* 求人なしメッセージ */
.no-jobs-message {
    text-align: center;
    padding: 60px 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
}

.no-jobs-message p {
    font-size: 16px;
    color: #666;
    margin-bottom: 20px;
}

.recruitment-contact-section {
    text-align: center;
}

.recruitment-contact-title {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 30px;
    position: relative;
}

.recruitment-contact-title::after {
    content: '';
    display: block;
    width: 60px;
    height: 4px;
    background-color: #f6b73c;
    margin: 15px auto 0;
}

/* レスポンシブ対応 */
@media (max-width: 768px) {
    .recruitment-container {
        padding: 30px 0px;
    }

    .recruitment-main-title {
        font-size: 24px;
        margin-bottom: 30px;
    }

    .recruitment-intro-text {
		text-align:left;
        font-size: 14px;
margin: 0px;
        margin-bottom: 40px;
    }

    .recruitment-info-row {
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .recruitment-info-label {
        margin-bottom: 5px;
        margin-right: 0;
    }

    .recruitment-section-title {
        font-size: 20px;
    }

    .job-tab {
        padding: 12px 5px;
        font-size: 14px;
        line-height: 1.3;
    }

    .job-tab-count {
        margin-top: 4px;
        font-size: 14px;
    }

    .job-tab-content {
        padding: 20px 0 0;
    }

    .job-container {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .recruitment-contact-title {
        font-size: 20px;
    }
	
	.job-container {
  display: grid;
}
}



</style>

<div class="recruitment-header-banner"></div>

<div class="recruitment-container">
    <?php 
    // ACFフィールドから値を取得
    $class_name = get_field('claas') ? get_field('claas') : 'こどもプラス教室';
    $address = get_field('addressa');
    $phone = get_field('tella');
    $website = get_field('web-urla');
    
    // 現在のページのACF「claas」から教室名を取得
    $current_class_name = get_field('claas');
    
    // テキストの長さを制限する関数
    function limit_text_job($text, $limit = 30) {
        if (mb_strlen($text) > $limit) {
            return mb_substr($text, 0, $limit) . '...';
        }
        return $text;
    }
    
    // 求人データを3つのカテゴリに分類
    $jobs_by_category = array(
        'manager' => array('name' => '児童発達支援<br>管理責任者', 'jobs' => array()),
        'staff' => array('name' => '保育士<br>児童指導員', 'jobs' => array()),
        'other' => array('name' => '専門職員<br>その他', 'jobs' => array())
    );
    
    if ($current_class_name) {
        $job_args = array(
            'post_type' => 'job',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            's' => $current_class_name,
            'orderby' => 'menu_order date',
            'order' => 'ASC'
        );
        $job_posts = get_posts($job_args);
        
        // 各求人を適切なカテゴリに分類
        foreach ($job_posts as $job_post) {
            $job_positions = get_the_terms($job_post->ID, 'job_position');
            $categorized = false;
            
            if ($job_positions && !is_wp_error($job_positions)) {
                foreach ($job_positions as $position) {
                    $position_name = $position->name;
                    $position_slug = $position->slug;
                    
                    // 児童発達支援管理責任者
                    if (strpos($position_name, '児発管') !== false || 
                        strpos($position_name, '児童発達支援管理責任者') !== false ||
                        strpos($position_slug, 'jidou-hattatsu-shien-kanri') !== false ||
                        strpos($position_slug, 'manager') !== false) {
                        $jobs_by_category['manager']['jobs'][] = $job_post;
                        $categorized = true;
                        break;
                    }
                    // 保育士・児童指導員
                    elseif (strpos($position_name, '保育士') !== false || 
                            strpos($position_name, '児童指導員') !== false ||
                            strpos($position_slug, 'hoikushi') !== false ||
                            strpos($position_slug, 'jidou-shidouin') !== false) {
                        $jobs_by_category['staff']['jobs'][] = $job_post;
                        $categorized = true;
                        break;
                    }
                }
            }
            
            // どのカテゴリにも該当しない場合は「その他」
            if (!$categorized) {
                $jobs_by_category['other']['jobs'][] = $job_post;
            }
        }
    }
    
    $has_jobs = !empty($job_posts);
    ?>

    <h2 class="recruitment-main-title"><?php echo esc_html($class_name); ?>の<br>求人情報一覧</h2>
    
    <div class="recruitment-intro-text">
        <?php 
        // 住所から番地以降を削除
        $display_address = $address;
        if ($address) {
            // 数字が最初に出現する位置を見つける
            if (preg_match('/^(.*?)[\d０-９]/u', $address, $matches)) {
                $display_address = $matches[1];
            }
            // 末尾の余分な記号を削除
            $display_address = rtrim($display_address, '、。・ ');
        }
        
        if ($has_jobs) {
            echo 'こどもプラス' . str_replace('こどもプラス', '', esc_html($class_name)) . 'では、' . esc_html($display_address) . 'にて放課後等デイサービス・児童発達支援のスタッフを募集しています。<br>こどもたちの成長を一緒に支えてくださる方のご応募を心よりお待ちしております。<br>※募集が終了している場合は、近隣教室の採用情報をご案内させていただくことがございます。';
        } else {
            echo esc_html($class_name) . '（' . esc_html($display_address) . '）の求人詳細については、下記のフォームよりお問い合わせください。<br>なお、募集がない場合は、近隣の教室をご案内させていただく場合がございます。';
        }
        ?>
    </div>

    <div class="recruitment-info-section">
        <?php if($address): ?>
        <div class="recruitment-info-row">
            <span class="recruitment-info-label">住所：</span>
            <span class="recruitment-info-value"><?php echo esc_html($address); ?></span>
        </div>
        <?php endif; ?>

        <?php if($phone): ?>
        <div class="recruitment-info-row">
            <span class="recruitment-info-label">電話番号：</span>
            <span class="recruitment-info-value"><?php echo esc_html($phone); ?></span>
        </div>
        <?php endif; ?>

        <?php if($website): ?>
        <div class="recruitment-info-row">
            <span class="recruitment-info-label">WEBサイト：</span>
            <span class="recruitment-info-value">
                <a href="<?php echo esc_url($website); ?>" target="_blank">
                    <?php echo esc_html($website); ?>
                </a>
            </span>
        </div>
        <?php endif; ?>
    </div>

    <?php if ($has_jobs): ?>
        <div class="recruitment-section">
            <h2 class="recruitment-section-title">求人内容・ご応募は各詳細から</h2>
            
            <!-- タブナビゲーション -->
            <div class="job-tabs">
                <?php 
                $first_tab = true;
                foreach ($jobs_by_category as $category_key => $category_data): 
                    if (!empty($category_data['jobs'])):
                ?>
                    <button class="job-tab <?php echo $first_tab ? 'active' : ''; ?>" data-tab="<?php echo esc_attr($category_key); ?>">
                        <span><?php echo $category_data['name']; ?></span>
                        <span class="job-tab-count"><?php echo count($category_data['jobs']); ?></span>
                    </button>
                <?php 
                    $first_tab = false;
                    endif;
                endforeach; 
                ?>
            </div>

            <!-- タブコンテンツ -->
            <?php 
            $first_content = true;
            foreach ($jobs_by_category as $category_key => $category_data): 
                if (!empty($category_data['jobs'])):
            ?>
            <div class="job-tab-content <?php echo $first_content ? 'active' : ''; ?>" id="tab-<?php echo esc_attr($category_key); ?>">
                <div class="job-container" data-tab-type="<?php echo esc_attr($category_key); ?>">
                    <?php 
                    $card_index = 0;
                    foreach ($category_data['jobs'] as $job_post): 
                        // 雇用形態を取得
                        $job_types = get_the_terms($job_post->ID, 'job_type');
                        $type_class = 'other';
                        if ($job_types && !is_wp_error($job_types)) {
                            $job_type_slug = $job_types[0]->slug;
                            $job_type_name = $job_types[0]->name;
                            
                            if (in_array($job_type_slug, ['full-time', 'seishain']) || $job_type_name === '正社員') {
                                $type_class = 'full-time';
                            } elseif (in_array($job_type_slug, ['part-time', 'part', 'arubaito']) || 
                                     strpos($job_type_name, 'パート') !== false || 
                                     strpos($job_type_name, 'アルバイト') !== false) {
                                $type_class = 'part-time';
                            }
                        }
                        
                        $hidden_class = ($card_index >= 3) ? ' hidden-card' : '';
                        echo render_job_card($job_post, $type_class, $current_class_name, $hidden_class);
                        $card_index++;
                    endforeach; 
                    ?>
                </div>
                <?php if (count($category_data['jobs']) > 3): ?>
                <div class="show-more-container">
                    <button class="show-more-btn" data-target="<?php echo esc_attr($category_key); ?>">
                        もっと見る（残り<?php echo count($category_data['jobs']) - 3; ?>件）
                    </button>
                </div>
                <?php endif; ?>
            </div>
            <?php 
                $first_content = false;
                endif;
            endforeach; 
            ?>
        </div>
    <?php else: ?>
        <div class="recruitment-section">
            <div class="no-jobs-message" style="display: none;">
                <p><?php echo esc_html($current_class_name); ?>の求人詳細情報は下記のフォームよりお問い合わせください。</p>
            </div>
        </div>
    <?php endif; ?>
    <div class="recruitment-contact-section">
        <?php echo do_shortcode('[contact-form-7 id="09d4612" title="お問い合わせ"]'); ?>
    </div>
</div>

<!-- 募集セクション -->
<section class="recruitment">
    <div class="container">
        <h2 class="recruitment-title">こどもプラスで一緒に働きませんか？</h2>
        <p class="recruitment-text">こどもたちの成長を支える喜びを一緒に感じましょう。<br>あなたのスキルや経験を活かせる場所がきっと見つかります。</p>
        <a href="/jobs" class="apply-button">募集中の求人を見る</a>
    </div>
</section>

<script>
// タブ切り替え機能
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.job-tab');
    const contents = document.querySelectorAll('.job-tab-content');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // すべてのタブとコンテンツから active クラスを削除
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));
            
            // クリックされたタブと対応するコンテンツに active クラスを追加
            this.classList.add('active');
            document.getElementById('tab-' + targetTab).classList.add('active');
        });
    });
    
    // もっと見るボタンの機能
    const showMoreButtons = document.querySelectorAll('.show-more-btn');
    
    showMoreButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetType = this.getAttribute('data-target');
            const container = document.querySelector('.job-container[data-tab-type="' + targetType + '"]');
            const hiddenCards = container.querySelectorAll('.jo-card.hidden-card');
            
            // 隠れているカードをすべて表示
            hiddenCards.forEach(card => {
                card.classList.remove('hidden-card');
            });
            
            // ボタンを非表示
            this.parentElement.style.display = 'none';
        });
    });
});
</script>

<?php 
// 求人カードをレンダリングする関数（既存のCSSを使用）
function render_job_card($job_post, $type_class, $current_class_name, $hidden_class = '') {
    $job_permalink = get_permalink($job_post->ID);
    
    // カスタムフィールドを取得
    $facility_name = get_post_meta($job_post->ID, 'facility_name', true);
    $facility_company = get_post_meta($job_post->ID, 'facility_company', true);
    $facility_address = get_post_meta($job_post->ID, 'facility_address', true);
    $salary_range = get_post_meta($job_post->ID, 'salary_range', true);
    $salary_type = get_post_meta($job_post->ID, 'salary_type', true);
    
    // 住所から郵便番号を削除
    $facility_address = preg_replace('/〒\d{3}-\d{4}\s*/', '', $facility_address);
    
    // テキストの長さを制限
    $facility_name = limit_text_job($facility_name, 20);
    $facility_company = limit_text_job($facility_company, 20);
    $facility_address = limit_text_job($facility_address, 30);
    $salary_range = limit_text_job($salary_range, 30);
    
    // タクソノミー情報を取得
    $position_display_text = get_job_position_display_text($job_post->ID);
    $position_name = !empty($position_display_text) ? limit_text_job($position_display_text, 20) : '';
    
    $job_types = get_the_terms($job_post->ID, 'job_type');
    $type_name = '';
    if ($job_types && !is_wp_error($job_types)) {
        $type_name = $job_types[0]->name;
    }
    
    // 特徴タグを取得
    $job_features = wp_get_object_terms($job_post->ID, 'job_feature', array('fields' => 'names'));
    
    // サムネイル画像URL
    $thumbnail_url = get_the_post_thumbnail_url($job_post->ID, 'medium');
    if (!$thumbnail_url) {
        $thumbnail_url = get_stylesheet_directory_uri() . '/images/job-image-default.jpg';
    }
    
    // 給与表示
    $salary_type_text = ($salary_type == 'HOUR') ? '時給 ' : '月給 ';
    
    ob_start();
    ?>
    <!-- 求人カード -->
    <div class="jo-card<?php echo $hidden_class; ?>">
        <div class="jo-header">
            <div class="cmpany-name">
                <p class="bold-text"><?php echo esc_html($facility_name); ?></p>
                <p><?php echo esc_html($facility_company); ?></p>
            </div>
            <div class="employment-type <?php echo $type_class; ?>">
                <?php echo esc_html($type_name); ?>
            </div>
        </div>
        <div class="jo-image">
            <img src="<?php echo esc_url($thumbnail_url); ?>" alt="求人画像">
        </div>
        <div class="jo-info">
            <h3 class="jo-title"><?php echo esc_html($position_name); ?></h3>
            <div class="inf-item">
                <span class="inf-icon"><i class="fa-solid fa-location-dot"></i></span>
                <p class="job-location"><?php echo esc_html($facility_address); ?></p>
            </div>
            <div class="inf-item">
                <span class="inf-icon"><i class="fa-solid fa-money-bill-wave"></i></span>
                <p class="job-sala">
                    <?php 
                    echo esc_html($salary_type_text . $salary_range);
                    if (strpos($salary_range, '円') === false) {
                        echo '円';
                    }
                    ?>
                </p>
            </div>
            <div class="job-tags">
                <?php if (!empty($job_features)) : 
                    $count = 0;
                    foreach ($job_features as $feature) : 
                        if ($count < 3) :
                            $feature = limit_text_job($feature, 15);
                ?>
                    <span class="feature-tag"><?php echo esc_html($feature); ?></span>
                <?php 
                        endif;
                        $count++;
                    endforeach; 
                endif; 
                ?>
            </div>
        </div>
        <div class="job-footer">
            <a href="<?php echo esc_url($job_permalink); ?>" class="detail-btn">詳細を見る <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

get_footer(); 
?>