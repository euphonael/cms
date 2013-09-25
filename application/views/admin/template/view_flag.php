				<fieldset id="item-flag">
                	<legend>Status</legend>
                    <div class="flag">
                    	<p>
                    		<input type="radio" name="flag" value="1" id="flag-active" <?php if ($row['flag'] == 1) echo 'checked="checked"'; ?> />
                            <label class="label-input" for="flag-active"><span class="flag active"></span>Active</label>
                            <span class="clear"></span>
                        </p>
                        <p>
                    		<input type="radio" name="flag" value="2" id="flag-inactive" <?php if ($row['flag'] == 2) echo 'checked="checked"'; ?> />
                            <label class="label-input" for="flag-inactive"><span class="flag inactive"></span>Inactive</label>
                            <span class="clear"></span>
                        </p>
                        <p>
                    		<input type="radio" name="flag" value="3" id="flag-delete" />
                            <label class="label-input" for="flag-delete"><span class="flag delete"></span>Delete</label>
                            <span class="clear"></span>
                        </p>
                    </div>
                    <div class="memo">
                    	<p>
                        	<label for="memo">Memo</label>
                            <textarea id="memo" name="memo"><?php echo (set_value('memo')) ? set_value('memo') : $row['memo']; ?></textarea>
                        </p>
                    </div>
                    <div class="clear"></div>
                </fieldset>