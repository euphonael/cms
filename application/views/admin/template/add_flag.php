                <fieldset id="item-flag">
                	<legend>Status</legend>
                    <div class="flag">
                    	<p>
                    		<input type="radio" name="flag" value="1" id="flag-active" <?php if (set_value('flag') == 1 || ! set_value('flag')) echo 'checked="checked"'; ?> />
                            <label class="label-input" for="flag-active"><span class="flag active"></span>Active</label>
                            <span class="clear"></span>
                        </p>
                        <p>
                    		<input type="radio" name="flag" value="2" id="flag-inactive" <?php if (set_value('flag') == 2) echo 'checked="checked"'; ?> />
                            <label class="label-input" for="flag-inactive"><span class="flag inactive"></span>Inactive</label>
                            <span class="clear"></span>
                        </p>
                    </div>
                    <div class="memo">
                    	<p>
                        	<label for="memo">Memo</label>
                            <textarea id="memo" name="memo"><?php echo set_value('memo'); ?></textarea>
                        </p>
                    </div>
                    <div class="clear"></div>
                </fieldset>
