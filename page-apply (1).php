<?php
/*
Template Name: 求人応募ページ
*/

// 求人IDを取得
$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;

// 求人情報を取得
$facility_name = '';
$job_position = '';
$job_type = '';

if ($job_id) {
    $job_post = get_post($job_id);
    if ($job_post && $job_post->post_type === 'job') {
        $facility_name = get_post_meta($job_id, 'facility_name', true);
        
        // 職種の「その他」対応（カスタム関数を使用）
        $job_position = get_job_position_display_text($job_id);
        
        // 雇用形態の「その他」対応（カスタム関数を使用）
        $job_type = get_job_type_display_text($job_id);
    }
}

// ユーザー情報を取得（ログインしている場合）
$user_data = array();
if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    $user_data = array(
        'oname' => get_user_meta($current_user->ID, 'oname', true),
        'tel' => get_user_meta($current_user->ID, 'tel', true),
        'seibetu' => get_user_meta($current_user->ID, 'seibetu', true),
        'age' => get_user_meta($current_user->ID, 'age', true),
        'postcode' => get_user_meta($current_user->ID, 'postcode', true),
        'prefectures' => get_user_meta($current_user->ID, 'prefectures', true),
        'municipalities' => get_user_meta($current_user->ID, 'municipalities', true),
        'streetaddress' => get_user_meta($current_user->ID, 'streetaddress', true),
        'Desiredtime' => get_user_meta($current_user->ID, 'Desiredtime', true),
        'years' => get_user_meta($current_user->ID, 'years', true),
        'qualification' => get_user_meta($current_user->ID, 'qualification', true),
        'user_email' => $current_user->user_email
    );
}

get_header();
?>

<div class="apply-page">
    <div class="apply-container">
        <h1>施設見学・求人応募フォーム</h1>
        
        <?php if ($job_id && !empty($facility_name)): ?>
        <div class="job-info-summary">
            <h2>応募求人情報</h2>
            <div class="job-detas">
                <p><strong>施設名：</strong><?php echo esc_html($facility_name); ?></p>
                <p><strong>職種：</strong><?php echo esc_html($job_position); ?></p>
                <p><strong>雇用形態：</strong><?php echo esc_html($job_type); ?></p>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if (is_user_logged_in()): ?>
        <div class="logged-in-notice">
            <p><span class="notice-icon">ℹ</span> 会員情報から自動入力されます。必要に応じて修正してください。</p>
        </div>
        <?php else: ?>
        <div class="not-logged-in-notice">
            <p><span class="notice-icon">!</span> <a href="/login/">ログイン</a>すると、会員情報が自動入力されます。</p>
        </div>
        <?php endif; ?>
        
        <!-- Contact Form 7 フォームを表示 -->
        <?php echo do_shortcode('[contact-form-7 id="f77f7df" title="求人応募フォーム"]'); ?>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    function fetchAddress(postcode) {
        postcode = postcode.replace(/-/g, '');
        
        if (postcode.length === 7) {
            $.ajax({
                url: 'https://zipcloud.ibsnet.co.jp/api/search',
                type: 'GET',
                dataType: 'jsonp',
                data: { zipcode: postcode },
                success: function(data) {
                    if (data.status === 200 && data.results) {
                        var result = data.results[0];
                        $('.prefecture-input').val(result.address1);
                        $('.municipality-input').val(result.address2 + result.address3);
                    }
                }
            });
        }
    }
    
    var jobData = {
        facility: '<?php echo esc_js($facility_name); ?>',
        position: '<?php echo esc_js($job_position); ?>',
        type: '<?php echo esc_js($job_type); ?>'
    };
    
    var userData = <?php echo json_encode($user_data); ?>;
    
    function setPlaceholders() {
        var placeholders = {
            'full_name': 'お名前を入力してください',
            'postcode': '例: 123-4567',
            'prefecture': '都道府県（自動入力されます）',
            'municipality': '市区町村（自動入力されます）',
            'street_address': '番地・建物名を入力してください',
            'phone_number': '例: 03-1234-5678',
            'email_address': 'example@email.com',
            'qualification_other': 'その他の資格を入力してください'
        };
        
        $.each(placeholders, function(name, placeholder) {
            var $input = $('input[name="' + name + '"], textarea[name="' + name + '"]');
            if ($input.length) {
                $input.attr('placeholder', placeholder);
            }
        });
    }
    
    function updatePlaceholders() {
        $('input, textarea').each(function() {
            if ($(this).val()) {
                $(this).attr('placeholder', '');
            }
        });
    }
    
    function fixBirthdateLayout() {
        var $yearWrap = $('.wpcf7-form-control-wrap[data-name="birth_year"]');
        var $monthWrap = $('.wpcf7-form-control-wrap[data-name="birth_month"]');
        var $dayWrap = $('.wpcf7-form-control-wrap[data-name="birth_day"]');
        
        if ($yearWrap.length && $monthWrap.length && $dayWrap.length) {
            $('.birthdate-wrapper-fixed').remove();
            var $wrapper = $('<div class="birthdate-wrapper-fixed"></div>');
            $wrapper.append($yearWrap).append($monthWrap).append($dayWrap);
            $('.birthdate-wrapper').replaceWith($wrapper);
        }
    }
    
    function forceQualificationGridStyle() {
        var $target = $('.wpcf7-form-control-wrap[data-name="qualification"] .wpcf7-checkbox');
        
        if ($target.length === 0) {
            $target = $('.qualification-checkbox-wrapper');
        }
        
        if ($target.length) {
            var isMobile = $(window).width() <= 768;
            
            // 既存のスタイルを完全にクリアしてから再適用
            $target.removeAttr('style');
            
            // インラインスタイルとして強制的に設定
            var flexStyles = 'display: flex !important; ' +
                            'flex-wrap: wrap !important; ' +
                            'margin: 0 0 15px 0 !important; ' +
                            'list-style: none !important; ' +
                            'padding: 0 !important; ' +
                            'width: 100% !important;';
            
            $target.attr('style', flexStyles);
            
            // 各アイテムに対してスタイルを設定
            $target.find('.wpcf7-list-item').each(function(index) {
                var itemStyles = 'display: inline-block !important; ' +
                               'margin: 0 !important; ' +
                               'padding: ' + (isMobile ? '0 7.5px 12px 0' : '0 10px 15px 0') + ' !important; ' +
                               'width: ' + (isMobile ? '50%' : '25%') + ' !important; ' +
                               'box-sizing: border-box !important;';
                
                $(this).attr('style', itemStyles);
            });
        }
    }
    
    function forceGenderGrid() {
        var $genderWrap = $('.wpcf7-form-control-wrap[data-name="gender"]');
        if ($genderWrap.length) {
            var $radio = $genderWrap.find('.wpcf7-radio');
            if ($radio.length) {
                $radio.addClass('gender-radio-grid-fixed');
            }
        }
    }
    
    setTimeout(function() {
        fixBirthdateLayout();
        forceQualificationGridStyle();
        forceGenderGrid();
        setPlaceholders();
        
        $(window).on('resize', function() {
            forceQualificationGridStyle();
        });
        
        if ($('input[name="job_facility"]').length && jobData.facility) {
            $('input[name="job_facility"]').val(jobData.facility);
        }
        if ($('input[name="job_position"]').length && jobData.position) {
            $('input[name="job_position"]').val(jobData.position);
        }
        if ($('input[name="job_type"]').length && jobData.type) {
            $('input[name="job_type"]').val(jobData.type);
        }
        
        if (userData.qualification && $('input[name="qualification[]"]').length) {
            var qualifications = userData.qualification.split(',');
            qualifications.forEach(function(qual) {
                var trimmedQual = qual.trim();
                $('input[name="qualification[]"][value="' + trimmedQual + '"]').prop('checked', true).closest('label').addClass('active');
            });
        }
        
        if (userData.oname) $('input[name="full_name"]').val(userData.oname);
        if (userData.seibetu) $('input[name="gender"][value="' + userData.seibetu + '"]').prop('checked', true).closest('label').addClass('active');
        if (userData.postcode) $('input[name="postcode"]').val(userData.postcode);
        if (userData.prefectures) $('input[name="prefecture"]').val(userData.prefectures);
        if (userData.municipalities) $('input[name="municipality"]').val(userData.municipalities);
        if (userData.streetaddress) $('input[name="street_address"]').val(userData.streetaddress);
        if (userData.tel) $('input[name="phone_number"]').val(userData.tel);
        if (userData.user_email) $('input[name="email_address"]').val(userData.user_email);
        
        $('.postcode-input').on('blur', function() {
            var postcode = $(this).val();
            if (postcode) fetchAddress(postcode);
        });
        
        function handleQualificationOther() {
            var $otherCheckbox = $('input[name="qualification[]"][value="その他"]');
            var $otherField = $('.qualification-other-field');
            
            if ($otherCheckbox.is(':checked')) {
                $otherField.slideDown(300);
                $('.qualification-other-input').attr('required', 'required');
            } else {
                $otherField.slideUp(300);
                $('.qualification-other-input').removeAttr('required').val('');
            }
        }
        
        $('input[name="qualification[]"]').on('change', function() {
            handleQualificationOther();
            $(this).closest('label').toggleClass('active', $(this).is(':checked'));
        });
        
        $('input[name="gender"]').on('change', function() {
            $('input[name="gender"]').closest('label').removeClass('active');
            if ($(this).is(':checked')) {
                $(this).closest('label').addClass('active');
            }
        });
        
        handleQualificationOther();
        $('input[type="radio"]:checked, input[type="checkbox"]:checked').each(function() {
            $(this).closest('label').addClass('active');
        });
        
        updatePlaceholders();
        
        $('input, textarea').on('input', function() {
            var name = $(this).attr('name');
            var placeholders = {
                'full_name': 'お名前を入力してください',
                'postcode': '例: 123-4567',
                'prefecture': '都道府県（自動入力されます）',
                'municipality': '市区町村（自動入力されます）',
                'street_address': '番地・建物名を入力してください',
                'phone_number': '例: 03-1234-5678',
                'email_address': 'example@email.com',
                'qualification_other': 'その他の資格を入力してください'
            };
            $(this).attr('placeholder', $(this).val() ? '' : (placeholders[name] || ''));
        });
        
    }, 1500);
});
</script>

<style>
.apply-page .wpcf7-form input[type="submit"] {
    width: auto; 
    min-width: 200px;
    display: block;
    margin: 0 auto 10px auto;
}

.apply-page {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.apply-container {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.apply-container h1 {
    color: #333;
    text-align: center;
    margin-bottom: 30px;
    font-size: 24px;
}

.job-info-summary {
    background-color: #f8f9fa;
    padding: 20px;
    margin-bottom: 20px;
    border-left: 4px solid #26b7a0;
}

.job-info-summary h2 {
    color: #26b7a0;
    font-size: 18px;
    margin-bottom: 15px;
}

.job-detas p {
    margin: 8px 0;
    color: #333;
}

.logged-in-notice,
.not-logged-in-notice {
    padding: 15px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}

.logged-in-notice {
    background-color: #e8f5e9;
    border-left: 4px solid #4caf50;
    color: #2e7d32;
}

.not-logged-in-notice {
    background-color: #fff3e0;
    border-left: 4px solid #ff9800;
    color: #e65100;
}

.notice-icon {
    font-weight: bold;
    margin-right: 10px;
    font-size: 18px;
}

.not-logged-in-notice a {
    color: #e65100;
    text-decoration: underline;
}

.not-logged-in-notice a:hover {
    color: #bf360c;
}

.apply-page .wpcf7 {
    max-width: 100%;
    margin: 0 !important;
    background-color: transparent !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    overflow: visible !important;
    padding: 0 !important;
}

.apply-page .wpcf7-form {
    max-width: 100%;
}

.apply-page .wpcf7-form label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

.apply-page .wpcf7-form .required {
    color: #e74c3c;
    margin-left: 5px;
}

.apply-page .wpcf7-form input[type="text"],
.apply-page .wpcf7-form input[type="email"],
.apply-page .wpcf7-form input[type="tel"],
.apply-page .wpcf7-form input[type="number"],
.apply-page .wpcf7-form textarea,
.apply-page .wpcf7-form select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 15px;
    font-size: 14px;
}

.apply-page .wpcf7-form input[readonly] {
    background-color: #f5f5f5;
    color: #666;
}

.apply-page .wpcf7-form input::placeholder,
.apply-page .wpcf7-form textarea::placeholder {
    color: #ccc;
    font-style: italic;
}

.apply-page .wpcf7-form textarea {
    resize: vertical;
    min-height: 100px;
}

.apply-page .wpcf7-form input[type="submit"] {
    background-color: #26b7a0;
    color: white;
    padding: 12px 30px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    width: 100%;
    transition: background-color 0.3s;
}

.apply-page .wpcf7-form input[type="submit"]:hover {
    background-color: #1f9688;
}

.apply-page .wpcf7-validation-errors {
    background-color: #ffeaa7;
    border: 1px solid #f1c40f;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.apply-page .wpcf7-not-valid-tip {
    font-size: 12px;
    color: #e74c3c;
    display: block;
    margin-top: 3px;
}

.postcode-note,
.qualification-note {
    font-size: 12px;
    color: #666;
    margin: -10px 0 15px 0;
    font-style: italic;
}

.qualification-note {
    margin: -5px 0 10px 0;
}

.apply-page .birthdate-wrapper-fixed {
    display: flex !important;
    flex-direction: row !important;
    gap: 15px !important;
    margin-bottom: 20px !important;
    align-items: flex-start !important;
    flex-wrap: nowrap !important;
}

.apply-page .birthdate-wrapper-fixed .wpcf7-form-control-wrap {
    flex: 1 !important;
    display: block !important;
    margin: 0 !important;
}

.apply-page .birthdate-wrapper-fixed select {
    width: 100% !important;
    margin-bottom: 0 !important;
    padding: 10px !important;
    border: 1px solid #ddd !important;
    border-radius: 5px !important;
    font-size: 14px !important;
    background-color: #fff !important;
    cursor: pointer !important;
    display: block !important;
}

body .apply-page .wpcf7-form .qualification-checkbox-wrapper .wpcf7-list-item label,
body .apply-page .wpcf7-form .wpcf7-form-control-wrap[data-name="qualification"] .wpcf7-checkbox .wpcf7-list-item label {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 15px 10px !important;
    border: 2px solid #ddd !important;
    border-radius: 8px !important;
    text-align: center !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important;
    background-color: #fff !important;
    font-weight: normal !important;
    margin: 0 !important;
    width: 100% !important;
    box-sizing: border-box !important;
    min-height: 52px !important;
}

body .apply-page .wpcf7-form .qualification-checkbox-wrapper .wpcf7-list-item input[type="checkbox"],
body .apply-page .wpcf7-form .wpcf7-form-control-wrap[data-name="qualification"] .wpcf7-checkbox .wpcf7-list-item input[type="checkbox"] {
    position: absolute !important;
    opacity: 0 !important;
    pointer-events: none !important;
    width: 0 !important;
    height: 0 !important;
}

body .apply-page .wpcf7-form .qualification-checkbox-wrapper .wpcf7-list-item label:hover,
body .apply-page .wpcf7-form .wpcf7-form-control-wrap[data-name="qualification"] .wpcf7-checkbox .wpcf7-list-item label:hover {
    border-color: #26b7a0 !important;
    background-color: #f0faf8 !important;
}

body .apply-page .wpcf7-form .qualification-checkbox-wrapper .wpcf7-list-item label.active,
body .apply-page .wpcf7-form .wpcf7-form-control-wrap[data-name="qualification"] .wpcf7-checkbox .wpcf7-list-item label.active {
    border-color: #26b7a0 !important;
    background-color: #f0faf8 !important;
}

body .apply-page .wpcf7-form .qualification-checkbox-wrapper .wpcf7-list-item span.wpcf7-list-item-label,
body .apply-page .wpcf7-form .wpcf7-form-control-wrap[data-name="qualification"] .wpcf7-checkbox .wpcf7-list-item span.wpcf7-list-item-label {
    border: none !important;
    padding: 0 !important;
    background: transparent !important;
    color: #333 !important;
    display: inline !important;
    margin: 0 !important;
    font-size: 14px !important;
}

body .apply-page .wpcf7-form .qualification-other-field {
    margin-bottom: 20px !important;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

body .apply-page .wpcf7-form .qualification-other-field label {
    display: block !important;
    margin-bottom: 5px !important;
    font-weight: bold !important;
    color: #333 !important;
}

body .apply-page .wpcf7-form .qualification-other-field input {
    width: 100% !important;
    padding: 10px !important;
    border: 1px solid #ddd !important;
    border-radius: 5px !important;
    font-size: 14px !important;
}

.apply-page .gender-radio-grid-fixed,
.apply-page .wpcf7-form-control-wrap[data-name="gender"] .wpcf7-radio,
.apply-page .radio-box-wrapper.gender-wrapper {
    display: grid !important;
    grid-template-columns: 1fr 1fr !important;
    gap: 15px 20px !important;
    margin-bottom: 15px !important;
}

.apply-page .gender-radio-grid-fixed .wpcf7-list-item,
.apply-page .wpcf7-form-control-wrap[data-name="gender"] .wpcf7-radio .wpcf7-list-item,
.apply-page .radio-box-wrapper.gender-wrapper .wpcf7-list-item {
    margin: 0 !important;
    display: block !important;
}

.apply-page .gender-radio-grid-fixed .wpcf7-list-item label,
.apply-page .wpcf7-form-control-wrap[data-name="gender"] .wpcf7-radio .wpcf7-list-item label,
.apply-page .radio-box-wrapper.gender-wrapper .wpcf7-list-item label {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 15px 20px !important;
    border: 2px solid #ddd !important;
    border-radius: 8px !important;
    text-align: center !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important;
    background-color: #fff !important;
    font-weight: normal !important;
    margin: 0 !important;
    width: 100% !important;
    box-sizing: border-box !important;
    min-height: 52px !important;
}

.apply-page .gender-radio-grid-fixed .wpcf7-list-item input[type="radio"],
.apply-page .wpcf7-form-control-wrap[data-name="gender"] .wpcf7-radio .wpcf7-list-item input[type="radio"],
.apply-page .radio-box-wrapper.gender-wrapper .wpcf7-list-item input[type="radio"] {
    position: absolute !important;
    opacity: 0 !important;
    pointer-events: none !important;
}

.apply-page .gender-radio-grid-fixed .wpcf7-list-item label:hover,
.apply-page .wpcf7-form-control-wrap[data-name="gender"] .wpcf7-radio .wpcf7-list-item label:hover,
.apply-page .radio-box-wrapper.gender-wrapper .wpcf7-list-item label:hover {
    border-color: #26b7a0 !important;
    background-color: #f0faf8 !important;
}

.apply-page .gender-radio-grid-fixed .wpcf7-list-item label.active,
.apply-page .wpcf7-form-control-wrap[data-name="gender"] .wpcf7-radio .wpcf7-list-item label.active,
.apply-page .radio-box-wrapper.gender-wrapper .wpcf7-list-item label.active {
    border-color: #26b7a0 !important;
    background-color: #f0faf8 !important;
}

.apply-page .gender-radio-grid-fixed .wpcf7-list-item span.wpcf7-list-item-label,
.apply-page .wpcf7-form-control-wrap[data-name="gender"] .wpcf7-radio .wpcf7-list-item span.wpcf7-list-item-label,
.apply-page .radio-box-wrapper.gender-wrapper .wpcf7-list-item span.wpcf7-list-item-label {
    border: none !important;
    padding: 0 !important;
    background: transparent !important;
    color: inherit !important;
    display: inline !important;
    margin: 0 !important;
}

@media (max-width: 768px) {
    .apply-page {
        padding: 0px;
    }
    
    .apply-container {
        padding: 10px;
    }
    
    .apply-container h1 {
        font-size: 20px;
    }
    
    .apply-page .birthdate-wrapper-fixed {
        gap: 10px !important;
    }
    
    .apply-page .birthdate-wrapper-fixed select {
        font-size: 14px !important;
        padding: 8px !important;
    }
    
    .apply-page .gender-radio-grid-fixed .wpcf7-list-item label,
    .apply-page .wpcf7-form-control-wrap[data-name="gender"] .wpcf7-radio .wpcf7-list-item label,
    .apply-page .radio-box-wrapper.gender-wrapper .wpcf7-list-item label {
        padding: 12px 15px !important;
        min-height: 48px !important;
        font-size: 14px !important;
    }
}

@media (max-width: 480px) {
    .apply-page .birthdate-wrapper-fixed {
        flex-direction: row !important;
        gap: 8px !important;
    }
    
    .apply-page .birthdate-wrapper-fixed select {
        font-size: 13px !important;
        padding: 8px 5px !important;
    }
    
    .apply-page .gender-radio-grid-fixed,
    .apply-page .wpcf7-form-control-wrap[data-name="gender"] .wpcf7-radio,
    .apply-page .radio-box-wrapper.gender-wrapper {
        grid-template-columns: 1fr !important;
    }
}
</style>

<?php get_footer(); ?>