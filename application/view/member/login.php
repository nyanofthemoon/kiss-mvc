<?php include( VIE . 'header'. EXT ) ?>

<!-- content -->

	<div id="content-nosidebar">
		<div class="post">

			<span class="left-entry">
				<h1 class="title"><?php echo Language::gettext('login-ret-member') ?></h1>
				<form action="<?php echo Controller::url('member', 'login') ?>" target="_parent" method="POST">
					<fieldset>
						<label for="username" class="required"><?php echo Language::gettext('login-form-username') ?></label>
						<input name="username" type="text">
					</fieldset>
					<fieldset>
						<label for="password" class="required"><?php echo Language::gettext('login-form-password') ?></label>
						<input name="password" type="password">
					</fieldset>
					<input type="submit" class="default" value="<?php echo Language::gettext('header-login') ?>" style="margin-bottom:460px">
				</form>
			</span>
			
			<span class="right-entry">
				<h1 class="title"><?php echo Language::gettext('login-new-member') ?></h1>
				<form action="<?php echo Controller::url('member', 'join') ?>" target="_parent" method="POST">

					<fieldset>
						<label for="username" class="required"><?php echo Language::gettext('login-form-username') ?></label>
						<input name="username" type="text">
					</fieldset>
					<fieldset>
						<label for="password" class="required"><?php echo Language::gettext('login-form-password') ?></label>
						<input name="password" type="password">
					</fieldset>
					<fieldset>
						<label for="repassword" class="required"><?php echo Language::gettext('login-form-password-confirm') ?></label></label>
						<input name="repassword" type="password">
					</fieldset>
					<br />
					<fieldset>
						<label for="full_name" class="required"><?php echo Language::gettext('login-form-full_name') ?></label>
						<input name="full_name" type="text">
					</fieldset>
					<fieldset>
						<label for="gender" class="required"><?php echo Language::gettext('login-form-gender') ?></label>
						<select name="gender"><?php foreach (User::getGenders() as $k=>$v) { echo '<option value="'.$k.'">'.ucfirst( $v ) .'</option>'; } ?></select>
					</fieldset>
					<fieldset>
						<label for="dob" class="required"><?php echo Language::gettext('login-form-dob') ?></label>
						<input name="dob" type="text" class="date-picker">
					</fieldset>
					<fieldset>
						<label for="occupation"><?php echo Language::gettext('login-form-occupation') ?></label>
						<input name="occupation" type="text">
					</fieldset>	
					<br />
					<fieldset>
						<label for="email" class="required"><?php echo Language::gettext('login-form-email') ?></label>
						<input name="email" type="text">
					</fieldset>
					<fieldset>
						<label for="address"><?php echo Language::gettext('login-form-address') ?></label>
						<input name="address" type="text">
					</fieldset>					
					<fieldset>
						<label for="city"><?php echo Language::gettext('login-form-city') ?></label>
						<input name="city" type="text">
					</fieldset>
					<fieldset>
						<label for="province"><?php echo Language::gettext('login-form-province') ?></label>
						<input name="province" type="text">
					</fieldset>
					<fieldset>
						<label for="birthplace"><?php echo Language::gettext('login-form-birthplace') ?></label>
						<input name="birthplace" type="text">
					</fieldset>
					<input type="submit" value="<?php echo Language::gettext('header-join') ?>" class="default">
					
				</form>
			</span>
		
			<div class="clear"></div>

		</div>
	</div>

<?php include( VIE . 'date-picker'. EXT ) ?>

<!-- content -->

<?php include( VIE . 'footer'. EXT ) ?>