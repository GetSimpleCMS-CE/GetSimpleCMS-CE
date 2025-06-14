<?php 
/**
 * View Salt Generator
 *
 * Displays Salt-Gen 
 *
 * @package GetSimple
 * @subpackage Support
 */

// Setup inclusions
$load['plugin'] = true;
include('inc/common.php');

// Variable Settings
login_cookie_check();

// Start salt

// Start secure session
session_start();
session_regenerate_id(true);

function gs_passhash($p, $salt = '') {
	if ($salt !== '') { 
		$logsalt = sha1($salt);
	} else { 
		$logsalt = null; 
	}
	return sha1($p . $logsalt);
}

function gs_custom_salt_hash($value, $salt = '') {
	if ($salt !== '') {
		return sha1($value . $salt);
	}
	return sha1($value);
}

// Initialize variables
$password = '';
$login_salt = $_POST['login_salt'] ?? '';
$custom_salt = $_POST['custom_salt'] ?? '';
$custom_value = $_POST['custom_value'] ?? '';
$password_hash = '';
$custom_hash = '';

// Process form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$password = $_POST['password'] ?? '';
	
	if (!empty($password)) {
		$password_hash = gs_passhash($password, $login_salt);
	}
	if (!empty($custom_value)) {
		$custom_hash = gs_custom_salt_hash($custom_value, $custom_salt);
	}
	
	unset($_POST['password']);
	$password = '';
}
// End salt

get_template('header', cl($SITENAME).' &raquo; '.i18n_r('SUPPORT').' &raquo; '.i18n_r('LOGS')); 
?>

<?php include('template/include-nav.php'); ?>

<style>
	.security-warning { 
		background: #fff8e1; 
		border-left: 4px solid #ffc107;
		padding: 12px 15px;
		margin-bottom: 25px;
		border-radius: 0 4px 4px 0;
		font-size: 0.95rem;
	}
	
	label { 
		display: block; 
		margin-bottom: 8px; 
		font-weight: 600;
		color: #2c3e50;
	}
	
	input[type="text"], 
	input[type="password"] {
		width: 100%; 
		padding: 10px; 
		margin-bottom: 18px; 
		border: 1px solid #ddd; 
		border-radius: 4px; 
		box-sizing: border-box;
		font-size: 1rem;
		transition: border-color 0.3s;
	}
	
	input[type="text"]:focus, 
	input[type="password"]:focus {
		border-color: #3498db;
		outline: none;
		box-shadow: 0 0 0 2px rgba(52,152,219,0.2);
	}
	
	input[type="submit"] {
		background: forestgreen; 
		color: white; 
		padding: 12px 20px; 
		border: none; 
		border-radius: 4px; 
		cursor: pointer; 
		font-size: 1rem;
		font-weight: 600;
		transition: background 0.3s;
	}
	
	input[type="submit"]:hover { 
		background: green; 
	}
	
	.result { 
		background: #f8f9fa; 
		padding: 20px; 
		border-radius: 6px; 
		margin-top: 25px; 
		border: 1px solid #e9ecef;
	}
	
	pre { 
		background: #2c3e50; 
		color: #ecf0f1;
		padding: 12px; 
		border-radius: 4px; 
		overflow-x: auto;
		position: relative;
		font-family: 'Courier New', monospace;
		font-size: 0.95rem;
	}
	
	.copy-btn {
		position: absolute;
		right: 8px;
		top: 8px;
		background: #3498db;
		color: white;
		border: none;
		border-radius: 3px;
		padding: 5px 10px;
		cursor: pointer;
		font-size: 0.85rem;
		transition: background 0.3s;
	}
	
	.copy-btn:hover { 
		background: #2980b9; 
	}
	
	.tabs { 
		display: flex; 
		margin-bottom: 20px;
		border-bottom: 1px solid #ddd;
	}
	
	.tab { 
		padding: 10px 25px; 
		cursor: pointer; 
		background: #f8f9fa; 
		margin-right: 5px; 
		border-radius: 4px 4px 0 0;
		font-weight: 600;
		color: #7f8c8d;
		transition: all 0.3s;
	}
	
	.tab.active { 
		background: #3498db; 
		color: white;
	}
	
	.tab:hover:not(.active) {
		background: #e9ecef;
	}
	
	.tab-content { 
		display: none; 
		padding: 20px 0;
	}
	
	.tab-content.active { 
		display: block; 
	}
	
	.toast {
		position: fixed;
		bottom: 25px;
		left: 50%;
		transform: translateX(-50%);
		background: #27ae60;
		color: white;
		padding: 12px 25px;
		border-radius: 4px;
		z-index: 1000;
		display: none;
		box-shadow: 0 3px 10px rgba(0,0,0,0.2);
		animation: fadeIn 0.3s;
	}
	.generate-btn {
		background: orange;
		color: white;
		border: none;
		border-radius: 4px;
		padding: 8px 12px;
		cursor: pointer;
		font-size: 0.85rem;
		margin-left: 8px;
		transition: background 0.3s;
	}
	
	.generate-btn:hover {
		background: darkorange;
	}
	
	.input-group {
		display: flex;
		align-items: center;
	}
	
	.input-group input[type="text"] {
		flex: 1;
		margin-bottom: 18px;
	}
	
	@keyframes fadeIn {
		from { opacity: 0; bottom: 15px; }
		to { opacity: 1; bottom: 25px; }
	}
	
	@media (max-width: 768px) {
		.tabs {
			flex-wrap: wrap;
		}
		
		.tab {
			margin-bottom: 5px;
		}
		
		.input-group {
			flex-direction: column;
			align-items: stretch;
		}
		
		.generate-btn {
			margin-left: 0;
			margin-top: -10px;
			margin-bottom: 18px;
		}
	}
</style>

<div class="bodycontent clearfix">
    <div id="maincontent">
        <div class="main">
		
			<div class="header-title">
				<h3><?php i18n('Security_Generator');?></h3>
				<p><?php i18n('More_info');?> <a href="https://github.com/GetSimpleCMS-CE/GetSimpleCMS-CE/wiki/Salt-Configuration" target="_blank" style="text-decoration:none;"><?php i18n('Wiki');?></a>.</p>
			</div>
			
			<div class="security-warning">
				<strong><?php i18n('Security_Notice');?>:</strong> <?php i18n('Tokens_are_never');?>
			</div>
			
			<div class="tabs">
				<div class="tab active" onclick="showTab('password')"><?php i18n('Password_Hash');?></div>
				<div class="tab" onclick="showTab('custom')"><?php i18n('Custom_Salt_Hash');?></div>
			</div>
			
			<form method="post" autocomplete="off">
			
				<!-- Password Hash Tab -->
				<div id="password-tab" class="tab-content active">
					<h2><?php i18n('Password_Hashing');?> (GSLOGINSALT)</h2>
					<p><?php i18n('Used_to_enhance');?></p>
					<label for="password"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="1.2em" height="1.2em" viewBox="0 0 32 32"><rect width="32" height="32" fill="none"/><path fill="#000" d="M21 2a8.998 8.998 0 0 0-8.612 11.612L2 24v6h6l10.388-10.388A9 9 0 1 0 21 2m0 16a7 7 0 0 1-2.032-.302l-1.147-.348l-.847.847l-3.181 3.181L12.414 20L11 21.414l1.379 1.379l-1.586 1.586L9.414 23L8 24.414l1.379 1.379L7.172 28H4v-3.172l9.802-9.802l.848-.847l-.348-1.147A7 7 0 1 1 21 18"/><circle cx="22" cy="10" r="2" fill="#000"/></svg> <?php i18n('Password_Token');?>:</label>
					<input type="password" id="password" name="password" autocomplete="new-password" placeholder="<?php i18n('Any_word');?>">
					
					<label for="login_salt"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="1.2em" height="1.2em" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="#000" d="m16.88 4l2.15 2.1l-5.53 4.4l-1-1L16.87 4zm0-2a2 2 0 0 0-1.55.72L9.8 9.65l3.54 3.54l6.94-5.52c.9-.76.97-2.13.13-2.97L18.3 2.59c-.4-.4-.91-.59-1.42-.59M9.1 10.36l-.71.71a1.02 1.02 0 0 0 0 1.43l2.11 2.1c.21.2.46.29.72.29s.51-.09.71-.29l.7-.7zM6 15c-.55 0-1 .45-1 1s.45 1 1 1s1-.45 1-1s-.45-1-1-1m3 1c-.55 0-1 .45-1 1s.45 1 1 1s1-.45 1-1s-.45-1-1-1m-5 2c-.55 0-1 .45-1 1s.45 1 1 1s1-.45 1-1s-.45-1-1-1m3 1c-.55 0-1 .45-1 1s.45 1 1 1s1-.45 1-1s-.45-1-1-1"/></svg> <?php i18n('System_Salt');?>:</label>
					<div class="input-group">
						<input type="text" id="login_salt" name="login_salt" value="<?= htmlspecialchars($login_salt) ?>" placeholder="<?php i18n('Random_string');?>">
						<button type="button" class="generate-btn" onclick="generateSalt('login_salt', 32)"><?php i18n('Generate');?></button>
					</div>
				</div>
				
				<!-- Custom Salt Hash Tab -->
				<div id="custom-tab" class="tab-content">
					<h2><?php i18n('Security_Hashing');?> (GSUSECUSTOMSALT)</h2>
					<p><?php i18n('enhance_system_wide');?></p>
					<label for="custom_value"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="1.2em" height="1.2em" viewBox="0 0 32 32"><rect width="32" height="32" fill="none"/><path fill="#000" d="M21 2a8.998 8.998 0 0 0-8.612 11.612L2 24v6h6l10.388-10.388A9 9 0 1 0 21 2m0 16a7 7 0 0 1-2.032-.302l-1.147-.348l-.847.847l-3.181 3.181L12.414 20L11 21.414l1.379 1.379l-1.586 1.586L9.414 23L8 24.414l1.379 1.379L7.172 28H4v-3.172l9.802-9.802l.848-.847l-.348-1.147A7 7 0 1 1 21 18"/><circle cx="22" cy="10" r="2" fill="#000"/></svg> <?php i18n('Input_Token');?>:</label>
					<input type="password" id="custom_value" name="custom_value" placeholder="<?php i18n('Any_word');?>">
					
					<label for="custom_salt"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="1.2em" height="1.2em" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="#000" d="m16.88 4l2.15 2.1l-5.53 4.4l-1-1L16.87 4zm0-2a2 2 0 0 0-1.55.72L9.8 9.65l3.54 3.54l6.94-5.52c.9-.76.97-2.13.13-2.97L18.3 2.59c-.4-.4-.91-.59-1.42-.59M9.1 10.36l-.71.71a1.02 1.02 0 0 0 0 1.43l2.11 2.1c.21.2.46.29.72.29s.51-.09.71-.29l.7-.7zM6 15c-.55 0-1 .45-1 1s.45 1 1 1s1-.45 1-1s-.45-1-1-1m3 1c-.55 0-1 .45-1 1s.45 1 1 1s1-.45 1-1s-.45-1-1-1m-5 2c-.55 0-1 .45-1 1s.45 1 1 1s1-.45 1-1s-.45-1-1-1m3 1c-.55 0-1 .45-1 1s.45 1 1 1s1-.45 1-1s-.45-1-1-1"/></svg> <?php i18n('Application_Salt');?>:</label>
					<div class="input-group">
						<input type="text" id="custom_salt" name="custom_salt" value="<?= htmlspecialchars($custom_salt) ?>" placeholder="<?php i18n('Random_string');?>">
						<button type="button" class="generate-btn" onclick="generateSalt('custom_salt', 64)"><?php i18n('Generate');?></button>
					</div>
				</div>
				
				<input type="submit" value="<?php i18n('Generate_Hashes');?>">
			</form>
			
			<?php if (!empty($password_hash) || !empty($custom_hash)): ?>
			<div class="result">
				<?php if (!empty($password_hash)): ?>
					<h3 style="color:darkorange;"><?php i18n('Password_Hash_Results');?> (GSLOGINSALT):</h3>
					<p><strong><?php i18n('Password_Token');?>:</strong> ******** (<?php i18n('hidden');?>)</p>
					<?php if (!empty($login_salt)): ?>
						<p><strong><?php i18n('System_Salt');?>:</strong> <?= htmlspecialchars($login_salt) ?></p>
						<p><strong><?php i18n('SHA1_of_Salt');?>:</strong> <?= sha1($login_salt) ?></p>
					<?php endif; ?>
					<p style="color:green;"><strong><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="1.2em" height="1.2em" viewBox="0 0 32 32"><rect width="32" height="32" fill="none"/><path fill="#000" d="M24.26 32H7.739a1.28 1.28 0 0 1-1.281-1.281V18.495c0-.708.573-1.286 1.281-1.286h1.552v-1.974c0-3.698 3.01-6.708 6.708-6.708s6.708 3.01 6.708 6.708v1.974h1.552c.708 0 1.281.578 1.281 1.286v12.224A1.28 1.28 0 0 1 24.259 32zm-7.421-6.76c1.521-.859.911-3.182-.839-3.182c-1.745.005-2.354 2.318-.839 3.182v1.656c0 1.115 1.677 1.115 1.677 0zm-3.698-8.032h5.724v-1.974c0-1.578-1.286-2.859-2.865-2.859s-2.859 1.281-2.859 2.859zm-7.078-1.817H2.079c-.651 0-1.172-.526-1.172-1.172s.521-1.172 1.172-1.172h3.984c.646 0 1.172.526 1.172 1.172s-.526 1.172-1.172 1.172M8.87 9.12a1.14 1.14 0 0 1-.74-.271L4.974 6.255a1.166 1.166 0 0 1-.156-1.646a1.166 1.166 0 0 1 1.646-.161L9.62 7.042c.849.698.349 2.078-.75 2.073zM16 6.359a1.174 1.174 0 0 1-1.172-1.172V1.171c0-.646.526-1.172 1.172-1.172s1.172.526 1.172 1.172v4.016c0 .646-.526 1.172-1.172 1.172m7.13 2.761c-1.104 0-1.599-1.38-.75-2.078l3.156-2.594c1.208-.99 2.693.818 1.49 1.813L23.87 8.855a1.16 1.16 0 0 1-.74.266zm6.792 6.271h-4.021c-.651 0-1.172-.526-1.172-1.172s.521-1.172 1.172-1.172h4.021c.651 0 1.172.526 1.172 1.172s-.521 1.172-1.172 1.172"/></svg> <?php i18n('Your_Hash');?>:</strong></p>
					<div style="position:relative">
						<pre id="password-hash"><?= $password_hash ?></pre>
						<button class="copy-btn" onclick="copyToClipboard('password-hash','GSLOGINSALT <?php i18n('hash_copied');?>')"><?php i18n('COPY');?></button>
					</div>
					<br>
					<ol>
						<li><?php i18n('Remain_logged');?></li>
						<li><?php i18n('Add_hash_GSLOGINSALT');?></li>
						<li><?php i18n('Update_all');?></li>
					</ol>
				<?php endif; ?>
				
				<?php if (!empty($custom_hash)): ?>
					<h3 style="color:darkorange;"><?php i18n('Custom_Salt');?> (GSUSECUSTOMSALT):</h3>
					<p><strong><?php i18n('Input_Token');?>:</strong> ******** (<?php i18n('hidden');?>)</p>
					<?php if (!empty($custom_salt)): ?>
						<p><strong><?php i18n('Application_Salt');?>:</strong> <?= htmlspecialchars($custom_salt) ?></p>
						<p><strong><?php i18n('SHA1_of_Application');?>:</strong> <?= sha1($custom_salt) ?></p>
					<?php endif; ?>
					<p style="color:green;"><strong><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="1.2em" height="1.2em" viewBox="0 0 32 32"><rect width="32" height="32" fill="none"/><path fill="#000" d="M24.26 32H7.739a1.28 1.28 0 0 1-1.281-1.281V18.495c0-.708.573-1.286 1.281-1.286h1.552v-1.974c0-3.698 3.01-6.708 6.708-6.708s6.708 3.01 6.708 6.708v1.974h1.552c.708 0 1.281.578 1.281 1.286v12.224A1.28 1.28 0 0 1 24.259 32zm-7.421-6.76c1.521-.859.911-3.182-.839-3.182c-1.745.005-2.354 2.318-.839 3.182v1.656c0 1.115 1.677 1.115 1.677 0zm-3.698-8.032h5.724v-1.974c0-1.578-1.286-2.859-2.865-2.859s-2.859 1.281-2.859 2.859zm-7.078-1.817H2.079c-.651 0-1.172-.526-1.172-1.172s.521-1.172 1.172-1.172h3.984c.646 0 1.172.526 1.172 1.172s-.526 1.172-1.172 1.172M8.87 9.12a1.14 1.14 0 0 1-.74-.271L4.974 6.255a1.166 1.166 0 0 1-.156-1.646a1.166 1.166 0 0 1 1.646-.161L9.62 7.042c.849.698.349 2.078-.75 2.073zM16 6.359a1.174 1.174 0 0 1-1.172-1.172V1.171c0-.646.526-1.172 1.172-1.172s1.172.526 1.172 1.172v4.016c0 .646-.526 1.172-1.172 1.172m7.13 2.761c-1.104 0-1.599-1.38-.75-2.078l3.156-2.594c1.208-.99 2.693.818 1.49 1.813L23.87 8.855a1.16 1.16 0 0 1-.74.266zm6.792 6.271h-4.021c-.651 0-1.172-.526-1.172-1.172s.521-1.172 1.172-1.172h4.021c.651 0 1.172.526 1.172 1.172s-.521 1.172-1.172 1.172"/></svg> <?php i18n('Your_Custome_Hash');?>:</strong></p>
					<div style="position:relative">
						<pre id="custom-hash"><?= $custom_hash ?></pre>
						<button class="copy-btn" onclick="copyToClipboard('custom-hash','GSUSECUSTOMSALT hash copied!')"><?php i18n('COPY');?></button>
					</div>
					<br>
					<ol>
						<li><?php i18n('Add_hash_GSUSECUSTOMSALT');?></li>
						<li><?php i18n('Clear_cookies');?></li>
					</ol>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<div class="toast" id="toast"></div>

			<script>
				// Tab switching
				function showTab(tabName) {
					document.querySelectorAll('.tab-content').forEach(tab => {
						tab.classList.remove('active');
					});
					document.querySelectorAll('.tab').forEach(tab => {
						tab.classList.remove('active');
					});
					
					document.getElementById(tabName + '-tab').classList.add('active');
					event.currentTarget.classList.add('active');
				}
				
				// Copy to clipboard
				function copyToClipboard(elementId, message) {
					const element = document.getElementById(elementId);
					const range = document.createRange();
					range.selectNode(element);
					window.getSelection().removeAllRanges();
					window.getSelection().addRange(range);
					
					try {
						document.execCommand('copy');
						showToast(message);
					} catch (err) {
						showToast('Failed to copy!');
					}
					
					window.getSelection().removeAllRanges();
				}
				
				// Random salt generator
				function generateSalt(fieldId, length) {
					const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_-+=';
					let result = '';
					
					if (window.crypto && window.crypto.getRandomValues) {
						const values = new Uint32Array(length);
						window.crypto.getRandomValues(values);
						for (let i = 0; i < length; i++) {
							result += chars[values[i] % chars.length];
						}
					} else {
						for (let i = 0; i < length; i++) {
							result += chars.charAt(Math.floor(Math.random() * chars.length));
						}
					}
					
					document.getElementById(fieldId).value = result;
					showToast(`Generated secure ${length}-char ${fieldId.includes('login') ? 'System Salt' : 'Application Key'}`);
				}
				
				// Toast notification
				function showToast(message) {
					const toast = document.getElementById('toast');
					toast.textContent = message;
					toast.style.display = 'block';
					
					setTimeout(() => {
						toast.style.display = 'none';
					}, 3000);
				}
			</script>
			
        </div>
    </div>
    <div id="sidebar">
        <?php include('template/sidebar-support.php'); ?>
    </div>    
</div>
<?php get_template('footer'); ?>
