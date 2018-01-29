<div class="clear"></div>
<div class="postbox rpespcontainer" id="dashboard_right_now" >
    <h3 class="hndle"><?php echo __('Delivery Date Settings', 'rpesp') ?><a href="admin.php?page=rpesp-import-shipping" style="float:right;" class="button button-primary"><?php echo __('Import Product Settings', 'rpesp') ?></a></h3>
    <div class="inside">
        <div class="main">
            <form method="post" action="" name="<?php echo self::$plugin_slug; ?>">
                <input type="hidden" name="<?php echo self::$plugin_slug; ?>" value="1"/>
                <table class="rp_table" >
                    <tr>
                        <td width="30%"><?php echo __('Enabled delivery date?', 'rpesp') ?></td>
                        <td>
                            <input type="checkbox" name="enable_delivery_date" <?php echo ($this->get_setting("enable_delivery_date")) ? "checked=checked" : ""; ?> value="1" />
                        </td>
                    </tr>
                    <tr>
                        <td width="30%"><?php echo __('Display on cart and checkout page?', 'rpesp') ?></td>
                        <td>
                            <input type="checkbox" name="enable_on_cart" <?php echo ($this->get_setting("enable_on_cart")) ? "checked=checked" : ""; ?> value="1" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="30%"><?php echo __('Display on order page?', 'rpesp') ?></td>
                        <td>
                            <input type="checkbox" name="enable_on_orderpage" <?php echo ($this->get_setting("enable_on_orderpage")) ? "checked=checked" : ""; ?> value="1" />
                        </td>
                    </tr>
                    <tr>
                        <td width="30%"><?php echo __('Display in order email?', 'rpesp') ?></td>
                        <td>
                            <input type="checkbox" name="enable_on_orderemail" <?php echo ($this->get_setting("enable_on_orderemail")) ? "checked=checked" : ""; ?> value="1" />
                        </td>
                    </tr>
                    <tr>
                        <td width="30%"><?php echo __('Hide if product out of stock?', 'rpesp') ?></td>
                        <td>
                            <input type="checkbox" name="hide_out_of_stock" <?php echo ($this->get_setting("hide_out_of_stock")) ? "checked=checked" : ""; ?> value="1" />
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo __('Text Position On Product Page', 'rpship') ?></td>
                        <td>
                            <select name="text_pos">
                                <option value="0" <?php echo ($this->get_setting("text_pos") == 0) ? "selected=selected" : ""; ?>>Below  Title</option>
                                <option value="1" <?php echo ($this->get_setting("text_pos") == 1) ? "selected=selected" : ""; ?>>After Description</option>
                                <option value="2" <?php echo ($this->get_setting("text_pos") == 2) ? "selected=selected" : ""; ?>>After Price</option>
                                <option value="3" <?php echo ($this->get_setting("text_pos") == 3) ? "selected=selected" : ""; ?>>After Add To Cart</option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td><?php echo __('Estimated date text', 'rpesp') ?></td>
                        <td>
                            <input type="text"  name="estimate_text" value="<?php echo $this->get_setting("estimate_text") ?>"/><br>
                            <span class="description">
                                <br><code>{d}</code>: <?php echo __('For display number of remaining days', 'rpesp') ?>
                                <br><code>{d+x}</code>: <?php echo __('x is number of additional day Example:{d+1},{d+2}..', 'rpesp') ?>
                                <br><code>{d-x}</code>: <?php echo __('x is number of additional day Example:{d-1},{d-2}..', 'rpesp') ?>
                                <br><code>{date}</code>: <?php echo __('For display delivery date', 'rpesp') ?>
                                <br><code>{date+x}</code>: <?php echo __('x is number of additional day Example:{date+1},{date+2}..', 'rpesp') ?>
                                <br><code>{date-x}</code>: <?php echo __('x is number of additional day Example:{date-1},{date-2}..', 'rpesp') ?><br>
                            </span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td><?php echo __('Text On order page', 'rpesp') ?></td>
                        <td>
                            <input type="text"  name="text_order" value="<?php echo $this->get_setting("text_order") ?>"/><br>
                            <span class="description">
                                <br><code>{date}</code>: <?php echo __('For display delivery date', 'rpesp') ?>
                                <br><code>{date+x}</code>: <?php echo __('x is number of additional day Example:{date+1},{date+2}..', 'rpesp') ?>
                                <br><code>{date-x}</code>: <?php echo __('x is number of additional day Example:{date-1},{date-2}..', 'rpesp') ?><br>
                            </span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td><?php echo __('Date Format', 'rpesp') ?></td>
                        <td>
                            <input type="text"  name="date_format" value="<?php echo $this->get_setting("date_format") ?>"/> <br>
                            <span class="description"><br>
                                <code>d</code>: <?php echo __('Day of month (2 digits with leading zeros)', 'rpesp') ?><br>
                                <code>D</code>: <?php echo __('A textual representation of a day, three letters', 'rpesp') ?><br>
                                <code>j</code>: <?php echo __('Day of the month without leading zeros', 'rpesp') ?><br>
                                <code>l</code>:<?php echo __('A full textual representation of the day of the week', 'rpesp') ?><br>
                                <code>m</code>: <?php echo __('Numeric representation of a month, with leading zeros', 'rpesp') ?><br>
                                <code>F</code>: <?php echo __('A full textual representation of a month, with leading zeros', 'rpesp') ?><br>
                                <code>M</code>: <?php echo __('A short textual representation of a month, three letters', 'rpesp') ?><br>
                                <code>n</code>: <?php echo __('Numeric representation of a month, without leading zeros', 'rpesp') ?><br>
                                <code>n</code>: <?php echo __('Numeric representation of a month, without leading zeros', 'rpesp') ?><br>
                                <code>Y</code>: <?php echo __('A full numeric representation of a year, 4 digits', 'rpesp') ?><br>
                                <code>y</code>: <?php echo __('A two digit representation of a year', 'rpesp') ?><br>
                                .</span>
                        </td>
                    </tr>

                    <tr valign="top">
                        <td><?php echo __('Week Day Off', 'rpesp') ?></td>
                        <td>
                            <?php
                            $weekday = $this->get_setting("weekdayoff");
                            foreach (self::$day as $key => $value):
                                $checked = (!empty($weekday) && is_array($weekday) && in_array($key, $weekday)) ? "checked=checked" : "";
                                echo '<input type="checkbox" ' . $checked . ' name="weekdayoff[' . $key . ']" value="' . $key . '"  value="' . $key . '">' . $value . "<br/>";
                            endforeach;
                            ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td><?php echo __('Specific Day Off', 'rpesp') ?></td>
                        <td>
                            <table id="tbl_specific_day">
                                <tr id="th_rpesp_specific_day">
                                    <th><?php echo __('Day', "rpesp") ?></th>
                                    <th><?php echo __('Month', "rpesp") ?></th>
                                    <th><?php echo __('Year', "rpesp") ?></th>
                                    <th>&nbsp;</th>
                                </tr>
                                <?php
                                $specific_day = $this->get_setting("specific_day");
                                if (!empty($specific_day) && isset($specific_day["day"]) && count($specific_day["day"]) > 0):
                                    for ($spe = 0; $spe < count($specific_day["day"]); $spe++):
                                        ?>
                                        <tr>
                                            <td>
                                                <select name="specific_day[day][]">
                                                    <option value="0"><?php echo __('Select Day', 'rpesp') ?></option>
                                                    <?php
                                                    for ($day = 1; $day <= 31; $day++):
                                                        $selected = ($specific_day["day"][$spe] == $day) ? "selected=selected" : "";
                                                        echo '<option value="' . $day . '" ' . $selected . ' >' . $day . '</option>';
                                                    endfor;
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="specific_day[month][]">
                                                    <option value="0"><?php echo __('Select Month', 'rpesp') ?></option>
                                                    <?php
                                                    foreach (self::$month as $key => $value):
                                                        $selected = ($specific_day["month"][$spe] == $key) ? "selected=selected" : "";
                                                        echo '<option value="' . $key . '" ' . $selected . ' >' . $value . '</option>';
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="specific_day[year][]">
                                                    <option value="0"><?php echo __('Select Year', 'rpesp') ?></option>
                                                    <?php
                                                    for ($year = date("Y"); $year <= date("Y") + 50; $year++):
                                                        $selected = ($specific_day["year"][$spe] == $year) ? "selected=selected" : "";
                                                        echo '<option value="' . $year . '" ' . $selected . ' >' . $year . '</option>';
                                                    endfor;
                                                    ?>
                                                </select>
                                            </td>
                                            <td><a href="javascript:void(0);" class="rpesp_removedayrow button"><?php _e("Remove", "rpesp") ?></a></td>
                                        </tr>
                                        <?php
                                    endfor;
                                    ?>

                                    <?php
                                endif;
                                ?>
                                <tr>
                                    <td colspan="4"><a href="javascript:void(0);" class="rpesp_adddayrow button"><?php _e("Add More", "rpesp") ?></a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td><?php echo __('Specific Period Off', 'rpesp') ?></td>
                        <td>
                            <table id="tbl_specific_period_day">
                                <tr id="th_rpesp_specific_period_day">
                                    <th><?php echo __('From Day', "rpesp") ?></th>
                                    <th><?php echo __('From  Month', "rpesp") ?></th>
                                    <th><?php echo __('From Year', "rpesp") ?></th>
                                    <th><?php echo __('To Day', "rpesp") ?></th>
                                    <th><?php echo __('To  Month', "rpesp") ?></th>
                                    <th><?php echo __('To Year', "rpesp") ?></th>
                                    <th>&nbsp;</th>
                                </tr>
                                <?php
                                $specific_period = $this->get_setting("specific_period");
                                if (!empty($specific_period) && isset($specific_period["fday"]) && count($specific_period["fday"]) > 0):
                                    for ($sp = 0; $sp < count($specific_period["fday"]); $sp++):
                                        ?>
                                        <tr>
                                            <td>
                                                <select name="specific_period[fday][]">
                                                    <option value="0"><?php echo __('Select Day', 'rpesp') ?></option>
                                                    <?php
                                                    for ($day = 1; $day <= 31; $day++):
                                                        $selected = ($specific_period["fday"][$sp] == $day) ? "selected=selected" : "";
                                                        echo '<option value="' . $day . '" ' . $selected . '>' . $day . '</option>';
                                                    endfor;
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="specific_period[fmonth][]">
                                                    <option value="0"><?php echo __('Select Month', 'rpesp') ?></option>
                                                    <?php
                                                    foreach (self::$month as $key => $value):
                                                        $selected = ($specific_period["fmonth"][$sp] == $key) ? "selected=selected" : "";
                                                        echo '<option value="' . $key . '" ' . $selected . ' >' . $value . '</option>';
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="specific_period[fyear][]">
                                                    <option value="0"><?php echo __('Select Year', 'rpesp') ?></option>
                                                    <?php
                                                    for ($year = date("Y"); $year <= date("Y") + 50; $year++):
                                                        $selected = ($specific_period["fyear"][$sp] == $year) ? "selected=selected" : "";
                                                        echo '<option value="' . $year . '" ' . $selected . ' >' . $year . '</option>';
                                                    endfor;
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="specific_period[tday][]">
                                                    <option value="0"><?php echo __('Select Day', 'rpesp') ?></option>
                                                    <?php
                                                    for ($day = 1; $day <= 31; $day++):
                                                        $selected = ($specific_period["tday"][$sp] == $day) ? "selected=selected" : "";
                                                        echo '<option value="' . $day . '" ' . $selected . '>' . $day . '</option>';
                                                    endfor;
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="specific_period[tmonth][]">
                                                    <option value="0"><?php echo __('Select Month', 'rpesp') ?></option>
                                                    <?php
                                                    foreach (self::$month as $key => $value):
                                                        $selected = ($specific_period["tmonth"][$sp] == $key) ? "selected=selected" : "";
                                                        echo '<option value="' . $key . '" ' . $selected . ' >' . $value . '</option>';
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="specific_period[tyear][]">
                                                    <option value="0"><?php echo __('Select Year', 'rpesp') ?></option>
                                                    <?php
                                                    for ($year = date("Y"); $year <= date("Y") + 50; $year++):
                                                        $selected = ($specific_period["tyear"][$sp] == $year) ? "selected=selected" : "";
                                                        echo '<option value="' . $year . '" ' . $selected . ' >' . $year . '</option>';
                                                    endfor;
                                                    ?>
                                                </select>
                                            </td>
                                            <td><a href="javascript:void(0);" class="rpesp_removeperiodrow button"><?php echo __("Remove", "rpesp") ?></a></td>
                                        </tr>
                                        <?php
                                    endfor;
                                endif;
                                ?>
                                <tr><td colspan="7"><a href="javascript:void(0);" class="rpesp_addperiodrow button"><?php echo __("Add More", "rpesp") ?></a></td></tr>        
                            </table>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td><?php echo __('Delivery End Time', 'rpesp') ?></td>
                        <td>
                            <select name="hours">
                                <option value="">Hours</option>
                                <?php
                                for ($i = 0; $i <= 23; $i++):
                                    $selected = $this->get_setting('hours') == $i ? "selected=selected" : "";
                                    echo '<option ' . $selected . ' value="' . $i . '" >' . $i . '</option>';
                                endfor;
                                ?>
                            </select>
                            <select name="minute">
                                <option value="">Minute</option>
                                <?php
                                for ($i = 0; $i <= 60; $i++):
                                    $selected = $this->get_setting('minute') == $i ? "selected=selected" : "";
                                    echo '<option ' . $selected . ' value="' . $i . '" >' . $i . '</option>';
                                endfor;
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td><?php echo __('Text color', 'rpesp') ?></td>
                        <td>
                            <input type="text" name="text_color" class="txtcolor" value="<?php echo $this->get_setting("text_color") ?>" />
                        </td>
                    </tr>
                    <tr valign="top">
                        <td><?php echo __('Text Size', 'rpesp') ?></td>
                        <td>
                            <input type="number" name="text_size" style="width:80px;"  value="<?php echo $this->get_setting("text_size") ?>" />&nbsp;<i>px</i>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <input type="submit" class="button button-primary" name="btn-rpesp-submit" value="<?php echo __("Save Settings", "rpesp") ?>" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<div style="display: none;">
    <table id="rpesp_tblinitrow">
        <tr class="rpesp_initrow">
            <td>
                <select name="specific_day[day][]">
                    <option value="0"><?php echo __('Select Day', 'rpesp') ?></option>
                    <?php
                    for ($day = 1; $day <= 31; $day++):
                        echo '<option value="' . $day . '">' . $day . '</option>';
                    endfor;
                    ?>
                </select>
            </td>
            <td>
                <select name="specific_day[month][]">
                    <option value="0"><?php echo __('Select Month', 'rpesp') ?></option>
                    <?php
                    foreach (self::$month as $key => $value):
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    endforeach;
                    ?>
                </select>
            </td>
            <td>
                <select name="specific_day[year][]">
                    <option value="0"><?php echo __('Select Year', 'rpesp') ?></option>
                    <?php
                    for ($year = date("Y"); $year <= date("Y") + 50; $year++):
                        echo '<option value="' . $year . '">' . $year . '</option>';
                    endfor;
                    ?>
                </select>
            </td>
            <td><a href="javascript:void(0);" class="rpesp_removedayrow button"><?php echo __("Remove", "rpesp"); ?></a></td>
        </tr>
    </table>
    <table id="rpesp_tblinitperiodrow">
        <tr class="rpesp_thinitperiodrow">
            <td>
                <select name="specific_period[fday][]">
                    <option value="0"><?php echo __('Select Day', 'rpesp') ?></option>
                    <?php
                    for ($day = 1; $day <= 31; $day++):
                        echo '<option value="' . $day . '">' . $day . '</option>';
                    endfor;
                    ?>
                </select>
            </td>
            <td>
                <select name="specific_period[fmonth][]">
                    <option value="0"><?php echo __('Select Month', 'rpesp') ?></option>
                    <?php
                    foreach (self::$month as $key => $value):
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    endforeach;
                    ?>
                </select>
            </td>
            <td>
                <select name="specific_period[fyear][]">
                    <option value="0"><?php echo __('Select Year', 'rpesp') ?></option>
                    <?php
                    for ($year = date("Y"); $year <= date("Y") + 50; $year++):
                        echo '<option value="' . $year . '">' . $year . '</option>';
                    endfor;
                    ?>
                </select>
            </td>
            <td>
                <select name="specific_period[tday][]">
                    <option value="0"><?php echo __('Select Day', 'rpesp') ?></option>
                    <?php
                    for ($day = 1; $day <= 31; $day++):
                        echo '<option value="' . $day . '">' . $day . '</option>';
                    endfor;
                    ?>
                </select>
            </td>
            <td>
                <select name="specific_period[tmonth][]">
                    <option value="0"><?php echo __('Select Month', 'rpesp') ?></option>
                    <?php
                    foreach (self::$month as $key => $value):
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    endforeach;
                    ?>
                </select>
            </td>
            <td>
                <select name="specific_period[tyear][]">
                    <option value="0"><?php echo __('Select Year', 'rpesp') ?></option>
                    <?php
                    for ($year = date("Y"); $year <= date("Y") + 50; $year++):
                        echo '<option value="' . $year . '">' . $year . '</option>';
                    endfor;
                    ?>
                </select>
            </td>
            <td><a href="javascript:void(0);" class="rpesp_removeperiodrow button"><?php echo __("Remove", "rpesp") ?></a></td>
        </tr>
    </table>
</div>