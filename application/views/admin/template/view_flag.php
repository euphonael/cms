				<fieldset id="item-flag">
                	<legend>Status</legend>
                    <div class="flag">
                    	<p>
                    		<input type="radio" name="flag" value="1" id="flag-active" <?php default_checked('flag', $row, 1); ?> />
                            <label class="label-input" for="flag-active"><span class="flag active"></span>Active</label>
                            <span class="clear"></span>
                        </p>
                        <p>
                    		<input type="radio" name="flag" value="2" id="flag-inactive" <?php default_checked('flag', $row, 2); ?> />
                            <label class="label-input" for="flag-inactive"><span class="flag inactive"></span>Inactive</label>
                            <span class="clear"></span>
                        </p>
                        <p>
                    		<input type="radio" name="flag" value="3" id="flag-delete" <?php default_checked('flag', $row, 3); ?> />
                            <label class="label-input" for="flag-delete"><span class="flag delete"></span>Delete</label>
                            <span class="clear"></span>
                        </p>
                    </div>
                    <div class="memo">
                    	<p>
                        	<label for="memo">Memo</label>
                            <textarea id="memo" name="memo"><?php echo form_value('memo', $row); ?></textarea>
                        </p>
                    </div>
                    <div class="clear"></div>
                </fieldset>