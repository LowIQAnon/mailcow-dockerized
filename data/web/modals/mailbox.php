<?php
if (!isset($_SESSION['mailcow_cc_role'])) {
	header('Location: /');
	exit();
}
?>
<!-- add mailbox modal -->
<div class="modal fade" id="addMailboxModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
        <h3 class="modal-title"><?=$lang['mailbox']['add_mailbox'];?></h3>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" data-cached-form="true" data-id="add_mailbox" role="form">
          <div class="form-group">
            <label class="control-label col-sm-2" for="local_part"><?=$lang['add']['mailbox_username'];?></label>
            <div class="col-sm-10">
              <input type="text" pattern="[A-Za-z0-9\.!#$%&'*+/=?^_`{|}~-]+" autocorrect="off" autocapitalize="none" class="form-control" name="local_part" id="local_part" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="domain"><?=$lang['add']['domain'];?>:</label>
            <div class="col-sm-10">
              <select data-live-search="true" id="addSelectDomain" name="domain" id="domain" required>
              <?php
              foreach (mailbox('get', 'domains') as $domain) {
                echo "<option>".htmlspecialchars($domain)."</option>";
              }
              ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="name"><?=$lang['add']['full_name'];?></label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="name" id="name">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="addInputQuota"><?=$lang['add']['quota_mb'];?>
              <br /><span id="quotaBadge" class="badge">max. - MiB</span>
            </label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="quota" min="1" max="" id="addInputQuota" disabled value="<?=$lang['add']['select_domain'];?>" required>
            <small class="help-block">min. 1</small>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="password"><?=$lang['add']['password'];?></label>
            <div class="col-sm-10">
            <input type="password" class="form-control" name="password" id="password" placeholder="" required>
            (<a href="#" class="generate_password">Generate</a>)
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="password2"><?=$lang['add']['password_repeat'];?></label>
            <div class="col-sm-10">
            <input type="password" class="form-control" name="password2" id="password2" placeholder="" required>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="checkbox">
              <label><input type="checkbox" value="1" name="active" checked> <?=$lang['add']['active'];?></label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button class="btn btn-default" id="add_item" data-id="add_mailbox" data-api-url='add/mailbox' data-api-attr='{}' href="#"><?=$lang['admin']['add'];?></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div><!-- add mailbox modal -->
<!-- add domain modal -->
<div class="modal fade" id="addDomainModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
        <h3 class="modal-title"><?=$lang['mailbox']['add_domain'];?></h3>
      </div>
      <div class="modal-body">
				<form class="form-horizontal" data-cached-form="true" data-id="add_domain" role="form">
					<div class="form-group">
						<label class="control-label col-sm-2" for="domain"><?=$lang['add']['domain'];?>:</label>
						<div class="col-sm-10">
						<input type="text" autocorrect="off" autocapitalize="none" class="form-control" name="domain" id="domain" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="description"><?=$lang['add']['description'];?></label>
						<div class="col-sm-10">
						<input type="text" class="form-control" name="description" id="description" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="aliases"><?=$lang['add']['max_aliases'];?></label>
						<div class="col-sm-10">
						<input type="number" class="form-control" name="aliases" id="aliases" value="400" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="mailboxes"><?=$lang['add']['max_mailboxes'];?></label>
						<div class="col-sm-10">
						<input type="number" class="form-control" name="mailboxes" id="mailboxes" value="10" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="maxquota"><?=$lang['add']['mailbox_quota_m'];?></label>
						<div class="col-sm-10">
						<input type="number" class="form-control" name="maxquota" id="maxquota" value="3072" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="quota"><?=$lang['add']['domain_quota_m'];?></label>
						<div class="col-sm-10">
						<input type="number" class="form-control" name="quota" id="quota" value="10240" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?=$lang['add']['backup_mx_options'];?></label>
						<div class="col-sm-10">
							<div class="checkbox">
							<label><input type="checkbox" value="1" name="backupmx"> <?=$lang['add']['relay_domain'];?></label>
							<br />
							<label><input type="checkbox" value="1" name="relay_all_recipients"> <?=$lang['add']['relay_all'];?></label>
							<p><?=$lang['add']['relay_all_info'];?></p>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
							<label><input type="checkbox" value="1" name="active" checked> <?=$lang['add']['active'];?></label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
              <button class="btn btn-default" id="add_item" data-id="add_domain" data-api-url='add/domain' data-api-attr='{}' href="#"><?=$lang['add']['add_domain_only'];?></button>
              <button class="btn btn-default" id="add_item" data-id="add_domain" data-api-url='add/domain' data-api-attr='{"restart_sogo":"1"}' href="#"><?=$lang['add']['add_domain_restart'];?></button>
						</div>
					</div>
					<p><span class="glyphicon glyphicon-exclamation-sign text-danger"></span> <?=$lang['add']['restart_sogo_hint'];?></p>
				</form>
      </div>
    </div>
  </div>
</div><!-- add domain modal -->
<!-- add resource modal -->
<div class="modal fade" id="addResourceModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
        <h3 class="modal-title"><?=$lang['mailbox']['add_resource'];?></h3>
      </div>
      <div class="modal-body">
				<form class="form-horizontal" data-cached-form="true" role="form" data-id="add_resource">
					<div class="form-group">
						<label class="control-label col-sm-2" for="description"><?=$lang['add']['description'];?></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="description" id="description" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="domain"><?=$lang['add']['domain'];?>:</label>
						<div class="col-sm-10">
							<select data-live-search="true" name="domain" id="domain" title="<?=$lang['add']['select'];?>" required>
							<?php
              foreach (mailbox('get', 'domains') as $domain) {
								echo "<option>".htmlspecialchars($domain)."</option>";
							}
							?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="domain"><?=$lang['add']['kind'];?>:</label>
						<div class="col-sm-10">
							<select name="kind" id="kind" title="<?=$lang['add']['select'];?>" required>
								<option value="location">Location</option>
								<option value="group">Group</option>
								<option value="thing">Thing</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="multiple_bookings_select"><?=$lang['add']['multiple_bookings'];?>:</label>
						<div class="col-sm-10">
							<select name="multiple_bookings_select" id="multiple_bookings_select" title="<?=$lang['add']['select'];?>" required>
								<option value="0"><?=$lang['mailbox']['booking_0'];?></option>
								<option value="-1" selected><?=$lang['mailbox']['booking_lt0'];?></option>
								<option value="custom"><?=$lang['mailbox']['booking_custom'];?></option>
							</select>
              <div style="display:none" id="multiple_bookings_custom_div">
                <hr>
                <input type="number" class="form-control" name="multiple_bookings_custom" id="multiple_bookings_custom">
              </div>
              <input type="hidden" name="multiple_bookings" id="multiple_bookings">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
							<label><input type="checkbox" value="1" name="active" checked> <?=$lang['add']['active'];?></label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
              <button class="btn btn-default" id="add_item" data-id="add_resource" data-api-url='add/resource' data-api-attr='{}' href="#"><?=$lang['admin']['add'];?></button>
						</div>
					</div>
				</form>
      </div>
    </div>
  </div>
</div><!-- add resource modal -->
<!-- add alias modal -->
<div class="modal fade" id="addAliasModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
        <h3 class="modal-title"><?=$lang['mailbox']['add_alias'];?></h3>
      </div>
      <div class="modal-body">
				<form class="form-horizontal" data-cached-form="true" role="form" data-id="add_alias">
					<input type="hidden" value="0" name="active">
					<div class="form-group">
						<label class="control-label col-sm-2" for="address"><?=$lang['add']['alias_address'];?></label>
						<div class="col-sm-10">
							<textarea autocorrect="off" autocapitalize="none" class="form-control" rows="5" name="address" id="address" required></textarea>
							<p><?=$lang['add']['alias_address_info'];?></p>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="goto"><?=$lang['add']['target_address'];?></label>
						<div class="col-sm-10">
							<textarea id="textarea_alias_goto" autocorrect="off" autocapitalize="none" class="form-control" rows="5" id="goto" name="goto" required></textarea>
							<p><?=$lang['add']['target_address_info'];?></p>
							<div class="checkbox">
                <label><input class="goto_checkbox" id="goto_null" type="checkbox" value="1" name="goto_null"> <?=$lang['add']['goto_null'];?></label>
							</div>
              <div class="checkbox">
                <label><input class="goto_checkbox" id="goto_spam" type="checkbox" value="1" name="goto_spam"> <?=$lang['add']['goto_spam'];?></label>
							</div>
              <div class="checkbox">
                <label><input class="goto_checkbox" id="goto_ham" type="checkbox" value="1" name="goto_ham"> <?=$lang['add']['goto_ham'];?></label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
							<label><input type="checkbox" value="1" name="active" checked> <?=$lang['add']['active'];?></label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
              <button class="btn btn-default" id="add_item" data-id="add_alias" data-api-url='add/alias' data-api-attr='{}' href="#"><?=$lang['admin']['add'];?></button>
						</div>
					</div>
				</form>
      </div>
    </div>
  </div>
</div><!-- add alias modal -->
<!-- add domain alias modal -->
<div class="modal fade" id="addAliasDomainModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
        <h3 class="modal-title"><?=$lang['mailbox']['add_domain_alias'];?></h3>
      </div>
      <div class="modal-body">
				<form class="form-horizontal" data-cached-form="true" role="form" data-id="add_alias_domain">
					<input type="hidden" value="0" name="active">
					<div class="form-group">
						<label class="control-label col-sm-2" for="alias_domain"><?=$lang['add']['alias_domain'];?></label>
						<div class="col-sm-10">
							<textarea autocorrect="off" autocapitalize="none" class="form-control" rows="5" name="alias_domain" id="alias_domain" required></textarea>
							<p><?=$lang['add']['alias_domain_info'];?></p>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="target_domain"><?=$lang['add']['target_domain'];?></label>
						<div class="col-sm-10">
							<select data-live-search="true" name="target_domain" id="target_domain" title="<?=$lang['add']['select'];?>" required>
							<?php
              foreach (mailbox('get', 'domains') as $domain) {
								echo "<option>".htmlspecialchars($domain)."</option>";
							}
							?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
							<label><input type="checkbox" value="1" name="active" checked> <?=$lang['add']['active'];?></label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
              <button class="btn btn-default" id="add_item" data-id="add_alias_domain" data-api-url='add/alias-domain' data-api-attr='{}' href="#"><?=$lang['admin']['add'];?></button>
						</div>
					</div>
				</form>
      </div>
    </div>
  </div>
</div><!-- add domain alias modal -->
<!-- add sync job modal -->
<div class="modal fade" id="addSyncJobModalAdmin" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
        <h3 class="modal-title"><?=$lang['add']['syncjob'];?></h3>
      </div>
      <div class="modal-body">
        <p class="help-block"><?=$lang['add']['syncjob_hint'];?></p>
				<form class="form-horizontal" data-cached-form="true" role="form" data-id="add_syncjob">
          <div class="form-group">
            <label class="control-label col-sm-2" for="username"><?=$lang['add']['username'];?>:</label>
            <div class="col-sm-10">
              <select data-live-search="true" id="addSelectUsername" name="username" id="username" required>
              <?php
              $domains = mailbox('get', 'domains');
              if (!empty($domains)) {
                foreach ($domains as $domain) {
                  $mailboxes = mailbox('get', 'mailboxes', $domain);
                  foreach ($mailboxes as $mailbox) {
                    echo "<option>".htmlspecialchars($mailbox)."</option>";
                  }
                }
              }
              ?>
              </select>
            </div>
          </div> 
					<div class="form-group">
						<label class="control-label col-sm-2" for="host1"><?=$lang['add']['hostname'];?></label>
						<div class="col-sm-10">
						<input type="text" class="form-control" name="host1" id="host1" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="port1"><?=$lang['add']['port'];?></label>
						<div class="col-sm-10">
						<input type="number" class="form-control" name="port1" id="port1" min="1" max="65535" value="143" required>
            <small class="help-block">1-65535</small>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="user1"><?=$lang['add']['username'];?></label>
						<div class="col-sm-10">
						<input type="text" class="form-control" name="user1" id="user1" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="password1"><?=$lang['add']['password'];?></label>
						<div class="col-sm-10">
						<input type="password" class="form-control" name="password1" id="password1" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="enc1"><?=$lang['add']['enc_method'];?></label>
						<div class="col-sm-10">
							<select name="enc1" id="enc1" title="<?=$lang['add']['select'];?>" required>
                <option selected>TLS</option>
                <option>SSL</option>
                <option>PLAIN</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="mins_interval"><?=$lang['add']['mins_interval'];?></label>
						<div class="col-sm-10">
              <input type="number" class="form-control" name="mins_interval" min="1" max="3600" value="20" required>
              <small class="help-block">1-3600</small>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="subfolder2"><?=$lang['edit']['subfolder2'];?></label>
						<div class="col-sm-10">
						<input type="text" class="form-control" name="subfolder2" id="subfolder2" value="External">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="maxage"><?=$lang['edit']['maxage'];?></label>
						<div class="col-sm-10">
						<input type="number" class="form-control" name="maxage" id="maxage" min="0" max="32000" value="0">
            <small class="help-block">0-32000</small>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="maxbytespersecond"><?=$lang['edit']['maxbytespersecond'];?></label>
						<div class="col-sm-10">
						<input type="number" class="form-control" name="maxbytespersecond" id="maxbytespersecond" min="0" max="125000000" value="0">
            <small class="help-block">0-125000000</small>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="timeout1"><?=$lang['edit']['timeout1'];?></label>
						<div class="col-sm-10">
						<input type="number" class="form-control" name="timeout1" id="timeout1" min="1" max="32000" value="600">
            <small class="help-block">1-32000</small>
						</div>
					</div>
          <div class="form-group">
						<label class="control-label col-sm-2" for="timeout2"><?=$lang['edit']['timeout2'];?></label>
						<div class="col-sm-10">
						<input type="number" class="form-control" name="timeout2" id="timeout2" min="1" max="32000" value="600">
            <small class="help-block">1-32000</small>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="exclude"><?=$lang['add']['exclude'];?></label>
						<div class="col-sm-10">
						<input type="text" class="form-control" name="exclude" id="exclude" value="(?i)spam|(?i)junk">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="custom_params"><?=$lang['add']['custom_params'];?></label>
						<div class="col-sm-10">
						<input type="text" class="form-control" name="custom_params" id="custom_params" placeholder="--delete2folders --otheroption">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
							<label><input type="checkbox" value="1" name="delete2duplicates" checked> <?=$lang['add']['delete2duplicates'];?> (--delete2duplicates)</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
							<label><input type="checkbox" value="1" name="delete1"> <?=$lang['add']['delete1'];?> (--delete1)</label>
							</div>
						</div>
					</div>
          <div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
							<label><input type="checkbox" value="1" name="delete2"> <?=$lang['add']['delete2'];?> (--delete2)</label>
							</div>
						</div>
					</div>
          <div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
							<label><input type="checkbox" value="1" name="automap" checked> <?=$lang['add']['automap'];?> (--automap)</label>
							</div>
						</div>
					</div>
          <div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
							<label><input type="checkbox" value="1" name="skipcrossduplicates"> <?=$lang['add']['skipcrossduplicates'];?> (--skipcrossduplicates)</label>
							</div>
						</div>
					</div>
          <div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
							<label><input type="checkbox" value="1" name="subscribeall" checked> <?=$lang['add']['subscribeall'];?> (--subscribeall)</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
							<label><input type="checkbox" value="1" name="active" checked> <?=$lang['add']['active'];?></label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
              <button class="btn btn-default" id="add_item" data-id="add_syncjob" data-api-url='add/syncjob' data-api-attr='{}' href="#"><?=$lang['admin']['add'];?></button>
						</div>
					</div>
				</form>
      </div>
    </div>
  </div>
</div><!-- add sync job modal -->
<!-- add add_filter modal -->
<div class="modal fade" id="addFilterModalAdmin" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
        <h3 class="modal-title">Filter</h3>
      </div>
      <div class="modal-body">
				<form class="form-horizontal" data-cached-form="true" role="form" data-id="add_filter">
          <div class="form-group">
            <label class="control-label col-sm-2" for="username"><?=$lang['add']['username'];?>:</label>
            <div class="col-sm-10">
              <select data-live-search="true" id="addSelectUsername" name="username" id="username" required>
              <?php
              $domains = mailbox('get', 'domains');
              if (!empty($domains)) {
                foreach ($domains as $domain) {
                  $mailboxes = mailbox('get', 'mailboxes', $domain);
                  foreach ($mailboxes as $mailbox) {
                    echo "<option>".htmlspecialchars($mailbox)."</option>";
                  }
                }
              }
              ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="filter_type"><?=$lang['add']['sieve_type'];?>:</label>
            <div class="col-sm-10">
              <select id="addFilterType" name="filter_type" id="filter_type" required>
                <option value="prefilter">Prefilter</option>
                <option value="postfilter">Postfilter</option>
              </select>
            </div>
          </div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="script_desc"><?=$lang['add']['sieve_desc'];?>:</label>
						<div class="col-sm-10">
						<input type="text" class="form-control" name="script_desc" id="script_desc" required maxlength="255">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="script_data">Script:</label>
						<div class="col-sm-10">
							<textarea autocorrect="off" spellcheck="false" autocapitalize="none" class="form-control" rows="20" id="script_data" name="script_data" required></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
              <p class="help-block"><?=$lang['add']['activate_filter_warn'];?></p>
							<div class="checkbox">
							<label><input type="checkbox" value="1" name="active" checked> <?=$lang['add']['active'];?></label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10" id="add_filter_btns">
              <button class="btn btn-default" id="validate_sieve" href="#"><?=$lang['add']['validate'];?></button>
              <button class="btn btn-success" id="add_item" data-id="add_filter" data-api-url='add/filter' data-api-attr='{}' href="#" disabled><?=$lang['admin']['add'];?></button>
						</div>
					</div>
				</form>
      </div>
    </div>
  </div>
</div><!-- add add_filter modal -->
<!-- add add_bcc modal -->
<div class="modal fade" id="addBCCModalAdmin" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
        <h3 class="modal-title"><?=$lang['mailbox']['bcc_maps'];?></h3>
      </div>
      <div class="modal-body">
				<form class="form-horizontal" data-cached-form="true" role="form" data-id="add_bcc">
          <div class="form-group">
            <label class="control-label col-sm-2" for="local_dest"><?=$lang['mailbox']['bcc_local_dest'];?>:</label>
            <div class="col-sm-10">
              <select data-live-search="true" id="addSelectLocalDest" name="local_dest" id="local_dest" required>
              <?php
              $domains = mailbox('get', 'domains');
              $alias_domains = mailbox('get', 'alias_domains');
              if (!empty($domains)) {
                foreach ($domains as $domain) {
                  echo "<option>".htmlspecialchars($domain)."</option>";
                }
              }
              if (!empty($alias_domains)) {
                foreach ($alias_domains as $alias_domain) {
                  echo "<option>".htmlspecialchars($alias_domain)."</option>";
                }
              }
              if (!empty($domains)) {
                foreach ($domains as $domain) {
                  $mailboxes = mailbox('get', 'mailboxes', $domain);
                  foreach ($mailboxes as $mailbox) {
                    echo "<option>".htmlspecialchars($mailbox)."</option>";
                  }
                }
              }
              ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="type"><?=$lang['mailbox']['bcc_map_type'];?>:</label>
            <div class="col-sm-10">
              <select id="addFBCCType" name="type" id="type" required>
                <option value="sender"><?=$lang['mailbox']['bcc_sender_map'];?></option>
                <option value="rcpt"><?=$lang['mailbox']['bcc_rcpt_map'];?></option>
              </select>
            </div>
          </div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="bcc_dest"><?=$lang['mailbox']['bcc_destination'];?>:</label>
						<div class="col-sm-10">
              <input type="text" class="form-control" name="bcc_dest" id="bcc_dest">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
							<label><input type="checkbox" value="1" name="active" checked> <?=$lang['add']['active'];?></label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
              <button class="btn btn-success" id="add_item" data-id="add_bcc" data-api-url='add/bcc' data-api-attr='{}' href="#"><?=$lang['admin']['add'];?></button>
						</div>
					</div>
				</form>
      </div>
    </div>
  </div>
</div><!-- add add_bcc modal -->
<!-- add add_recipient_map modal -->
<div class="modal fade" id="addRecipientMapModalAdmin" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
        <h3 class="modal-title"><?=$lang['mailbox']['recipient_maps'];?></h3>
      </div>
      <div class="modal-body">
				<form class="form-horizontal" data-cached-form="true" role="form" data-id="add_recipient_map">
          <div class="form-group">
            <label class="control-label col-sm-2" for="recipient_map_old"><?=$lang['mailbox']['recipient_map_old'];?></label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="recipient_map_old" id="recipient_map_old">
            <small><?=$lang['mailbox']['recipient_map_old_info'];?></small>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="recipient_map_new"><?=$lang['mailbox']['recipient_map_new'];?></label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="recipient_map_new" id="recipient_map_new">
            <small><?=$lang['mailbox']['recipient_map_new_info'];?></small>
            </div>
          </div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
							<label><input type="checkbox" value="1" name="active" checked> <?=$lang['add']['active'];?></label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
              <button class="btn btn-success" id="add_item" data-id="add_recipient_map" data-api-url='add/recipient_map' data-api-attr='{}' href="#"><?=$lang['admin']['add'];?></button>
						</div>
					</div>
				</form>
      </div>
    </div>
  </div>
</div><!-- add add_recipient_map modal -->
<!-- log modal -->
<div class="modal fade" id="syncjobLogModal" tabindex="-1" role="dialog" aria-labelledby="syncjobLogModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header"><h4 class="modal-title">Log</h4></div>
      <div class="modal-body">
        <textarea class="form-control" rows="20" id="logText" spellcheck="false"></textarea>
      </div>
    </div>
  </div>
</div><!-- log modal -->
<!-- DNS info modal -->
<div class="modal fade" id="dnsInfoModal" tabindex="-1" role="dialog" aria-labelledby="dnsInfoModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header"><h4 class="modal-title"><?=$lang['diagnostics']['dns_records'];?></h4></div>
      <div class="modal-body">
        <p><?=$lang['diagnostics']['dns_records_24hours'];?></p>
        <div class="dns-modal-body"></div>
      </div>
    </div>
  </div>
</div><!-- DNS info modal -->
<script>
$('#addResourceModal').on('shown.bs.modal', function() {
  $("#multiple_bookings").val($("#multiple_bookings_select").val());
  if ($("#multiple_bookings").val() == "custom") {
    $("#multiple_bookings_custom_div").show();
    $("#multiple_bookings").val($("#multiple_bookings_custom").val());
  }
})
$("#multiple_bookings_select").change(function() {
  $("#multiple_bookings").val($("#multiple_bookings_select").val());
  if ($("#multiple_bookings").val() == "custom") {
    $("#multiple_bookings_custom_div").show();
  }
  else {
    $("#multiple_bookings_custom_div").hide();
  }
});
$("#multiple_bookings_custom").bind ("change keypress keyup blur", function () {
  $("#multiple_bookings").val($("#multiple_bookings_custom").val());
});
</script>
