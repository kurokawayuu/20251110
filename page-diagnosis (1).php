<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<?php wp_head(); ?>
    <style>
        body {
            font-family: '游ゴシック体', 'Yu Gothic', 'ヒラギノ角ゴ Pro', 'Hiragino Kaku Gothic Pro', 'メイリオ', 'Meiryo', sans-serif;
        }
        
        /* 職種選択ボタンのスタイル */
        .job-type-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .job-type-btn {
            padding: 25px 20px;
            border: 3px solid #e2e8f0;
            border-radius: 16px;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            font-size: 17px;
            font-weight: 700;
            color: #2d3748;
            position: relative;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        /* ホバー時のキラキラエフェクト */
        .job-type-btn::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent 30%,
                rgba(255, 255, 255, 0.3) 50%,
                transparent 70%
            );
            transform: rotate(45deg);
            transition: all 0.6s ease;
            opacity: 0;
        }

        .job-type-btn:hover::before {
            opacity: 1;
            left: 100%;
        }

        .job-type-btn:hover {
            border-color: #ff9800;
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 8px 20px rgba(255, 152, 0, 0.25);
        }

        /* アイコンスタイル */
        .job-type-btn i {
            display: block;
            font-size: 32px;
            margin-bottom: 10px;
            color: #ff9800;
            transition: all 0.3s ease;
        }

        .job-type-btn:hover i {
            transform: scale(1.2) rotate(5deg);
            color: #ff6f00;
        }

        .job-type-btn.selected {
            border-color: #ff9800;
            background: linear-gradient(135deg, #ff9800, #ff6f00);
            color: white;
            box-shadow: 0 8px 25px rgba(255, 152, 0, 0.5);
            transform: translateY(-4px) scale(1.02);
        }

        .job-type-btn.selected i {
            color: white;
            transform: scale(1.1);
        }

        .job-type-btn.selected::after {
            content: '✓';
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            font-weight: bold;
            background: white;
            color: #ff9800;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            animation: checkPop 0.3s ease;
        }

        @keyframes checkPop {
            0% {
                transform: scale(0);
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }

        /* クリック時のアニメーション */
        .job-type-btn:active {
            transform: translateY(-2px) scale(0.98);
        }

        /* 元のselectを非表示 */
        body.step-1 select#jobtype {
            display: none !important;
        }

        /* ボタンコンテナを表示 */
        body.step-1 .job-type-buttons {
            display: grid !important;
        }

        .diagnosis-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .diagnosis-header-badge {
            background: #1DD1B0;
            color: white;
            text-align: center;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(77, 208, 225, 0.3);
        }

        /* WEBレイアウト */
        .diagnosis-hero-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 40px;
        }

        .diagnosis-desktop-layout {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .diagnosis-mobile-layout {
            display: none;
        }

        .diagnosis-title-content {
            flex: 0 0 auto;
        }

        .diagnosis-image-content {
            flex: 0 0 auto;
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .diagnosis-main-heading {
            text-align: center;
            margin-bottom: 0;
            padding-right: 10px;
        }

        .diagnosis-mobile-heading {
            text-align: center;
            margin-bottom: 20px;
        }

        .diagnosis-main-heading h1 {
            font-size: 50px;
            margin-bottom: 0;
            line-height: 1.3;
        }

        .diagnosis-orange-highlight {
            color: #ff9800;
            font-weight: bold;
        }

        .diagnosis-teal-highlight {
            color: #1DD1B0;
            font-weight: bold;
        }

        .diagnosis-hero-img-wrapper {
            text-align: center;
            margin-bottom: 0;
        }

        .diagnosis-hero-img-wrapper img {
            max-width: 100%;
            width: 600px;
            height: auto;
            display: block;
        }

        .diagnosis-mobile-img-wrapper img {
            max-width: 100%;
            width: 100%;
            height: auto;
            display: block;
        }

        .diagnosis-feature-grid {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .diagnosis-desktop-features {
            display: flex;
        }

        .diagnosis-mobile-features {
            display: none;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 40px;
        }

        .diagnosis-feature-item {
            flex: 1;
            background: white;
            padding: 25px 20px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            font-size: 20px;
            font-weight: bold;
            line-height: 1.6;
        }

        .diagnosis-feature-item[style*="background: #fff3e0"] strong {
            color: #e65100;
        }

        .diagnosis-feature-item[style*="background: #e8f5e9"] strong {
            color: #2e7d32;
        }

        .diagnosis-feature-item[style*="background: #e3f2fd"] strong {
            color: #1565c0;
        }

        .diagnosis-intro-block {
            text-align: center;
            margin-bottom: 40px;
        }

        .diagnosis-intro-block h2 {
            font-size: 35px;
            color: #333;
        }

        .diagnosis-intro-block p {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        /* メインコンテンツエリア */
        .main-content-area {
            display: flex;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .left-column {
            flex: 2;
        }

        .right-column {
            flex: 1;
        }

        .multi-step-wrapper {
            max-width: 100%;
            margin: 0;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }

        .progress-bar {
            height: 6px;
            background: #e2e8f0;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #ff9800, #ff6f00);
            width: 25%;
            transition: width 0.3s ease;
        }

        .step-header {
            padding: 30px;
            text-align: center;
            background: #f7fafc;
        }

        .step-number {
            color: #ff9800;
            font-weight: 600;
            font-size: 14px;
        }

        .step-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a202c;
            margin-top: 8px;
        }

        .form-container {
            padding: 30px;
        }

        fieldset {
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        fieldset > legend {
            display: none !important;
        }

        fieldset > label,
        fieldset > .div_text,
        fieldset > .div_select,
        fieldset > .div_number,
        fieldset > .wpmem-optional-accordion,
        fieldset > p,
        fieldset > .button_div,
        fieldset > .req-text {
            display: none !important;
        }

        body.step-1 label[for="jobtype"],
        body.step-1 .div_select:has(#jobtype) {
            display: block !important;
        }

        body.step-2 label[for="oname"],
        body.step-2 .div_text:has(#oname),
        body.step-2 label[for="user_email"],
        body.step-2 .div_text:has(#user_email) {
            display: block !important;
        }

        body.step-3 label[for="password"],
        body.step-3 .div_text:has(#password),
        body.step-3 label[for="confirm_password"],
        body.step-3 .div_text:has(#confirm_password) {
            display: block !important;
        }

        body.step-4 label[for="postcode"],
        body.step-4 .div_text:has(#postcode),
        body.step-4 label[for="prefectures"],
        body.step-4 .div_text:has(#prefectures),
        body.step-4 label[for="municipalities"],
        body.step-4 .div_text:has(#municipalities),
        body.step-4 label[for="streetaddress"],
        body.step-4 .div_text:has(#streetaddress) {
            display: block !important;
        }

        body.step-4 .wpmem-optional-accordion {
            display: block !important;
            margin-top: 24px !important;
        }

        .wpmem-optional-accordion {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
        }

        .wpmem-accordion-header {
            padding: 16px 20px;
            background: #f7fafc;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .wpmem-accordion-header:hover {
            background: #edf2f7;
        }

        .wpmem-accordion-title {
            font-weight: 600;
            color: #2d3748;
        }

        .wpmem-optional-badge {
            font-size: 12px;
            padding: 4px 12px;
            background: #ff9800;
            color: white;
            border-radius: 12px;
            margin-left: 8px;
        }

        .wpmem-accordion-icon {
            transition: transform 0.3s ease;
            color: #718096;
        }

        .wpmem-accordion-header.active .wpmem-accordion-icon {
            transform: rotate(180deg);
        }

        .wpmem-accordion-content {
            transition: max-height 0.3s ease;
        }

        label {
            font-weight: 600 !important;
            margin-bottom: 8px !important;
            display: block !important;
            color: #2d3748 !important;
            font-size: 16px !important;
        }

        .req {
            color: #e53e3e !important;
        }

        input.textbox,
        select.dropdown {
            width: 100% !important;
            padding: 14px 16px !important;
            border: 2px solid #e2e8f0 !important;
            border-radius: 10px !important;
            font-size: 16px !important;
            transition: all 0.3s ease !important;
            box-sizing: border-box !important;
        }

        input.textbox:focus,
        select.dropdown:focus {
            border-color: #ff9800 !important;
            outline: none !important;
            box-shadow: 0 0 0 4px rgba(255, 152, 0, 0.1) !important;
        }

        .div_text,
        .div_select,
        .div_number {
            margin-bottom: 20px !important;
        }

        .zipcode-help {
            font-size: 14px;
            color: #718096;
            margin-top: 6px;
        }

        .step-navigation {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        .btn {
            flex: 1;
            padding: 14px 24px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-back {
            background: #f7fafc;
            color: #4a5568;
        }

        .btn-back:hover {
            background: #edf2f7;
        }

        .btn-next {
            background: linear-gradient(135deg, #ff9800, #ff6f00);
            color: white;
        }

        .btn-next:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);
        }

        .benefits-container {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 20px;
        }

        .benefits-title {
            font-size: 24px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 25px;
            text-align: center;
            position: relative;
        }

        .benefits-title:after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: linear-gradient(135deg, #ff9800, #ff6f00);
            margin: 10px auto;
            border-radius: 2px;
        }

        .benefits-list {
            margin-bottom: 30px;
        }

        .benefit-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 25px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .benefit-item:hover {
            background: #f1f3f4;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .benefit-item:last-child {
            margin-bottom: 0;
        }

        .benefit-icon {
            flex: 0 0 auto;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #ff9800, #ff6f00);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .benefit-content {
            flex: 1;
        }

        .benefit-title {
            font-size: 16px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 5px;
            line-height: 1.4;
        }

        .benefit-description {
            font-size: 14px;
            color: #718096;
            line-height: 1.5;
            margin: 0;
        }

        .privacy-note {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: #e8f5e9;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #2e7d32;
        }

        .privacy-note i {
            color: #2e7d32;
            font-size: 18px;
            margin-top: 2px;
            flex: 0 0 auto;
        }

        .privacy-note p {
            font-size: 13px;
            color: #2e7d32;
            margin: 0;
            line-height: 1.5;
        }

        .privacy-note a {
            color: #1565c0;
            text-decoration: underline;
            font-weight: 600;
        }

        .privacy-note a:hover {
            color: #0d47a1;
        }

        .banner-container {
            margin: 40px auto;
            text-align: center;
            max-width: 1200px;
            padding: 0 20px;
        }

        .banner-link {
            display: block;
            text-decoration: none;
        }

        .banner-image {
            max-width: 100%;
            height: auto;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            display: block;
            margin: 0 auto;
        }

        .banner-link:hover .banner-image {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .banner-pc {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        .banner-mobile {
            display: none !important;
        }

        .banner-fallback {
            margin: 20px 0;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .banner-fallback:hover {
            transform: translateY(-2px);
        }

        /* ステップ1: ラベルの後にボタンを配置 */
        body.step-1 .div_select:has(#jobtype) {
            display: flex !important;
            flex-direction: column;
        }

        body.step-1 label[for="jobtype"] {
            display: block !important;
            order: 1;
            margin-bottom: 15px !important;
        }

        body.step-1 #jobtype {
            display: none !important;
        }

        body.step-1 .job-type-buttons {
            order: 2;
        }

        @media (max-width: 768px) {
    /* モバイルで3つを画面幅に収める */
    .diagnosis-mobile-features {
        display: grid !important;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        margin-bottom: 40px;
    }

    .diagnosis-feature-item {
        padding: 12px 8px;
        text-align: center;
        min-width: 0;
        font-size: 11px;
        line-height: 1.4;
    }

    .diagnosis-feature-item strong {
        font-size: 14px;
        display: block;
        margin-bottom: 4px;
    }

    /* 職種ボタンを2列に変更 */
    .job-type-buttons {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 10px;
    }

    .job-type-btn {
        padding: 18px 12px;
        font-size: 15px;
    }

    .job-type-btn i {
        font-size: 24px;
        margin-bottom: 6px;
    }

    .diagnosis-intro-block h2 {
        font-size: 23px;
    }
    
    .diagnosis-wrapper {
        padding: 0px;
        padding-top: 15px;
    }

    .diagnosis-header-badge {
        font-size: 20px;
        padding: 12px 20px;
    }

    .diagnosis-desktop-layout {
        display: none;
    }

    .diagnosis-desktop-features {
        display: none;
    }

    .diagnosis-mobile-layout {
        display: block;
    }

    .diagnosis-main-heading h1 {
        font-size: 34px;
    }

    .main-content-area {
        flex-direction: column;
        gap: 20px;
        padding: 0 10px;
    }

    .multi-step-wrapper {
        margin: 0;
    }
    
    .step-header,
    .form-container {
        padding: 20px;
    }

    .benefits-container {
        margin-top: 30px;
        position: static;
        padding: 25px;
    }

    .benefits-title {
        font-size: 20px;
    }

    .benefit-item {
        padding: 15px;
        gap: 12px;
    }

    .benefit-icon {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }

    .benefit-title {
        font-size: 15px;
    }

    .benefit-description {
        font-size: 13px;
    }

    .banner-pc {
        display: none !important;
    }

    .banner-mobile {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    .banner-container {
        margin: 20px auto;
        padding: 0 10px;
    }
}
    </style>
</head>
<body>
    <div class="diagnosis-wrapper">
        <div class="diagnosis-header-badge">放課後等デイサービスの求人情報-全国190教室以上のこどもプラス</div>

        <div id="diagnosis-intro-screen">
            <div class="diagnosis-hero-section diagnosis-desktop-layout">
                <div class="diagnosis-title-content">
                    <div class="diagnosis-main-heading">
                        <h1><span class="diagnosis-orange-highlight">ご応募前に</span><br><span class="diagnosis-teal-highlight">"職場の雰囲気"を<br>チェックできる！</span></h1>
                    </div>
                </div>
                <div class="diagnosis-image-content">
                    <div class="diagnosis-hero-img-wrapper">
                        <img src="https://recruitment.kodomo-plus.co.jp/wp-content/uploads/2025/10/1e8bcc6b953fa9f494c6025805a30ed7.png" alt="タイトル画像" class="skip-lazy no-lazy" loading="eager">
                    </div>
                </div>
            </div>

            <div class="diagnosis-mobile-layout">
                <div class="diagnosis-main-heading diagnosis-mobile-heading">
                    <h1><span class="diagnosis-orange-highlight">ご応募前に</span><br><span class="diagnosis-teal-highlight">"職場の雰囲気"を<br>チェックできる！</span></h1>
                </div>
                <div class="diagnosis-mobile-img-wrapper">
                    <img src="https://recruitment.kodomo-plus.co.jp/wp-content/uploads/2025/10/1e8bcc6b953fa9f494c6025805a30ed7.png" alt="タイトル画像" class="skip-lazy no-lazy" loading="eager">
                </div>
            </div>

            <div class="diagnosis-intro-block">
                
                <h2>まずは簡単登録で求人をチェック！</h2>
<p>未経験でも安心の研修や先輩スタッフの声もチェック可能。自分に合った職場を今すぐ見つけましょう！</p>
            </div>        
        </div>
    </div>   

    <div class="main-content-area">
        <div class="left-column">
            <div class="multi-step-wrapper">
                <div class="progress-bar">
                    <div class="progress-fill" id="progressBar"></div>
                </div>       
                <div class="step-header">
                    <div class="step-number" id="stepNumber">ステップ 1 / 4</div>
                    <h1 class="step-title" id="stepTitle">ご希望職種</h1>
                </div>

                <div class="form-container">
                    <?php echo do_shortcode('[wpmem_form register]'); ?>

                    <div class="job-type-buttons" id="jobTypeButtons" style="display: none;">
                        <div class="job-type-btn" data-value="保育士">
                            <i class="fas fa-child"></i>
                            保育士
                        </div>
                        <div class="job-type-btn" data-value="児童指導員">
                            <i class="fas fa-hands-helping"></i>
                            児童指導員
                        </div>
                        <div class="job-type-btn" data-value="児童発達支援管理責任者">
                            <i class="fas fa-user-tie"></i>
                            児発管
                        </div>
                        <div class="job-type-btn" data-value="理学療法士">
                            <i class="fas fa-walking"></i>
                            理学療法士
                        </div>
                        <div class="job-type-btn" data-value="作業療法士">
                            <i class="fas fa-hand-holding-heart"></i>
                            作業療法士
                        </div>
                        <div class="job-type-btn" data-value="言語聴覚士">
                            <i class="fas fa-comments"></i>
                            言語聴覚士
                        </div>
                        <div class="job-type-btn" data-value="その他職員">
                            <i class="fas fa-user-friends"></i>
                            その他職員
                        </div>
                    </div>

                    <div class="step-navigation">
                        <button type="button" class="btn btn-back" id="prevBtn" style="display:none">戻る</button>
                        <button type="button" class="btn btn-next" id="nextBtn">次へ</button>
                    </div>
</div>
            </div>
        </div>

        <div class="right-column">
            <div class="benefits-container">
                <h2 class="benefits-title">会員登録のメリット</h2>
                <div class="benefits-list">
                    <?php 
                    $benefits = [
                        ['icon' => 'fa-search', 'title' => '求人情報の検索', 'description' => '希望条件に合った求人をカンタンに検索できます'],
                        ['icon' => 'fa-bell', 'title' => '新着求人お知らせ', 'description' => '希望条件に合った新着求人をメールでお知らせします'],
                        ['icon' => 'fa-heart', 'title' => 'お気に入り機能', 'description' => '気になる求人を保存して後で確認できます'],
                    ];
                    
                    foreach ($benefits as $benefit) : ?>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas <?php echo esc_attr($benefit['icon']); ?>"></i>
                        </div>
                        <div class="benefit-content">
                            <h3 class="benefit-title"><?php echo esc_html($benefit['title']); ?></h3>
                            <p class="benefit-description"><?php echo esc_html($benefit['description']); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="privacy-note">
                    <i class="fas fa-shield-alt"></i>
                    <p>お客様の個人情報は個人情報保護方針に基づき適切に管理いたします。</p>
                </div>
            </div>
        </div>
    </div>

<script>
(function() {
    let currentStep = 1;
    const totalSteps = 4;
    
    function fetchAddressFromPostcode(postcode) {
        const cleanPostcode = postcode.replace(/-/g, '');
        if (cleanPostcode.length !== 7) return;
        
        fetch('https://zipcloud.ibsnet.co.jp/api/search?zipcode=' + cleanPostcode)
            .then(response => response.json())
            .then(data => {
                if (data.status === 200 && data.results) {
                    const result = data.results[0];
                    const prefecturesInput = document.getElementById('prefectures');
                    if (prefecturesInput) prefecturesInput.value = result.address1;
                    
                    const municipalitiesInput = document.getElementById('municipalities');
                    if (municipalitiesInput) municipalitiesInput.value = result.address2;
                    
                    const streetaddressInput = document.getElementById('streetaddress');
                    if (streetaddressInput) {
                        streetaddressInput.value = result.address3 || '';
                        streetaddressInput.focus();
                    }
                } else {
                    alert('郵便番号から住所が見つかりませんでした。');
                }
            })
            .catch(error => {
                console.error('住所取得エラー:', error);
                alert('住所の取得に失敗しました。');
            });
    }
    
    const stepTitles = {
        1: 'ご希望職種',
        2: 'お名前とメールアドレス',
        3: 'パスワード',
        4: '住所情報',
        5: '登録完了'
    };
    
    const stepFields = {
        1: ['jobtype'],
        2: ['oname', 'user_email'],
        3: ['password', 'confirm_password'],
        4: ['postcode', 'prefectures', 'municipalities', 'streetaddress']
    };

    function initJobTypeButtons() {
        const buttons = document.querySelectorAll('.job-type-btn');
        const selectElement = document.getElementById('jobtype');
        
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                buttons.forEach(btn => btn.classList.remove('selected'));
                this.classList.add('selected');
                
                if (selectElement) {
                    selectElement.value = this.getAttribute('data-value');
                }
            });
        });
    }

    function updateStep() {
        document.body.className = '';
        document.body.classList.add('step-' + currentStep);
        
        const progress = (currentStep / totalSteps) * 100;
        document.getElementById('progressBar').style.width = progress + '%';
        
        document.getElementById('stepNumber').textContent = 'ステップ ' + currentStep + ' / ' + totalSteps;
        document.getElementById('stepTitle').textContent = stepTitles[currentStep];
        
        document.getElementById('prevBtn').style.display = currentStep === 1 ? 'none' : 'block';
        document.getElementById('nextBtn').textContent = currentStep === totalSteps ? '登録' : '次へ';
        
        const jobTypeButtons = document.getElementById('jobTypeButtons');
        if (currentStep === 1 && jobTypeButtons) {
            jobTypeButtons.style.display = 'grid';
        } else if (jobTypeButtons) {
            jobTypeButtons.style.display = 'none';
        }
    }

    function scrollToForm() {
        const formContainer = document.querySelector('.form-container');
        if (formContainer) {
            formContainer.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }
    }

    function validateStep() {
        const fields = stepFields[currentStep];
        let isValid = true;
        let errorMessage = '';
        
        if (currentStep === 1) {
            const selectElement = document.getElementById('jobtype');
            if (!selectElement || !selectElement.value || selectElement.value === '') {
                errorMessage = '職種を選択してください';
                isValid = false;
            }
        } else {
            fields.forEach(function(fieldName) {
                const input = document.getElementById(fieldName);
                if (input && input.hasAttribute('required')) {
                    const value = input.value.trim();
                    if (!value || value === '' || value === '---- 選択してください ----') {
                        input.style.borderColor = '#e53e3e';
                        isValid = false;
                        errorMessage = '必須項目を入力してください';
                    } else {
                        if (fieldName === 'user_email') {
                            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                            if (!emailPattern.test(value)) {
                                input.style.borderColor = '#e53e3e';
                                isValid = false;
                                errorMessage = '正しいメールアドレスを入力してください';
                            } else {
                                input.style.borderColor = '#e2e8f0';
                            }
                        } else {
                            input.style.borderColor = '#e2e8f0';
                        }
                    }
                }
            });
        }
        
        if (currentStep === 3) {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            if (password && confirmPassword && password.value !== confirmPassword.value) {
                confirmPassword.style.borderColor = '#e53e3e';
                alert('パスワードが一致しません');
                return false;
            }
        }
        
        if (!isValid && errorMessage) {
            alert(errorMessage);
        }
        
        return isValid;
    }

    function nextStep() {
        if (!validateStep()) {
            return;
        }
        
        if (currentStep === totalSteps) {
            const allInputs = document.querySelectorAll('fieldset input[required], fieldset select[required]');
            const requiredFields = [];
            
            allInputs.forEach(function(input) {
                if (input.offsetParent === null) {
                    requiredFields.push(input);
                    input.removeAttribute('required');
                }
            });
            
            const submitBtn = document.querySelector('input[name="submit"]');
            if (submitBtn) {
                submitBtn.click();
            }
            
            setTimeout(function() {
                requiredFields.forEach(function(input) {
                    input.setAttribute('required', '');
                });
            }, 100);
        } else {
            currentStep++;
            updateStep();
            scrollToForm();
        }
    }

    function prevStep() {
        if (currentStep > 1) {
            currentStep--;
            updateStep();
            scrollToForm();
        }
    }

    document.getElementById('nextBtn').addEventListener('click', nextStep);
    document.getElementById('prevBtn').addEventListener('click', prevStep);

    document.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && (e.target.matches('input.textbox') || e.target.matches('select.dropdown'))) {
            e.preventDefault();
            nextStep();
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target.id === 'postcode') {
            const postcode = e.target.value;
            const cleanPostcode = postcode.replace(/-/g, '');
            if (cleanPostcode.length === 7) {
                fetchAddressFromPostcode(postcode);
            }
        }
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.wpmem-accordion-header')) {
            const header = e.target.closest('.wpmem-accordion-header');
            const content = header.nextElementSibling;
            const icon = header.querySelector('.wpmem-accordion-icon');
            
            header.classList.toggle('active');
            
            if (header.classList.contains('active')) {
                content.style.maxHeight = content.scrollHeight + 'px';
                if (icon) icon.textContent = '▲';
            } else {
                content.style.maxHeight = '0px';
                if (icon) icon.textContent = '▼';
            }
        }
    });

    function checkForSuccessMessage() {
        const formContent = document.querySelector('fieldset');
        if (formContent) {
            const text = formContent.innerText || formContent.textContent;
            if (text.includes('ご登録ありがとうございます') || 
                text.includes('メールアドレスの認証') || 
                text.includes('registration complete') ||
                text.includes('Thank you for registering') ||
                !document.getElementById('jobtype')) {
                
                const stepHeader = document.querySelector('.step-header');
                const stepNav = document.querySelector('.step-navigation');
                const progressBar = document.querySelector('.progress-bar');
                
                if (stepHeader) stepHeader.style.display = 'none';
                if (stepNav) stepNav.style.display = 'none';
                if (progressBar) progressBar.style.display = 'none';
                
                document.body.className = 'registration-complete';
                return true;
            }
        }
        return false;
    }
    
    if (!checkForSuccessMessage()) {
        updateStep();
        initJobTypeButtons();
    }
})();
</script>
<?php wp_footer(); ?>
</body>
</html>