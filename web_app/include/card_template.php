<div class="row card word_card" id="<?php echo $wordObj['wordID']; ?>" style="padding:10px 12px 13px 12px;">
    <div class="large-12 columns">
        <h3>
            <?php echo $wordObj['word']; ?>
            <?php
            if(Pronunciation::check_word_file_is_present($wordObj['word']))
            {
            ?>
            <img src="resources/img/common/speaker.png" class="speaker" style="margin-right:10px;" id="<?php echo Pronunciation::getFileName($wordObj['word']); ?>"/>
            <?php
            }
            ?>
            <?php
            if ($wordObj['word_fav'] == false)
            {
                echo '<img class="star-select" src="resources/img/common/star_select.png" alt="fav"/>';
            }
            else
            {
                echo '<img class="star-unselect" src="resources/img/common/star_unselect.png" alt="fav"/>';
            }
            ?>
            <?php
            $filename = basename($_SERVER['REQUEST_URI']);
            if (strpos($filename, 'dashboard') !== false || strpos($filename, 'fav') !== false)
            {
            ?>
                <img class="ignore right" src="resources/img/common/cross.png" alt="ignore"/>
            <?php
            }
            ?>
        </h3>
        <hr>
        <label><strong>Short Definition : </strong><?php echo $wordObj['definition_short']; ?></label>
        <?php
        for ($i = 0; $i < sizeof($wordObj['defintion_arr']); $i++)
        {
        ?>
        <div class="definition">
            <label><strong>Definition</strong><?php echo $wordObj['defintion_arr'][$i]['def']; ?></label>
            <?php
            if (sizeof($wordObj['defintion_arr'][$i]['syn']) > 0) {
                ?>
                <label>
                    <strong>Synonyms : </strong>
                    <?php
                    for ($j = 0; $j < sizeof($wordObj['defintion_arr'][$i]['syn']); $j++) {
                        $syn_word = $wordObj['defintion_arr'][$i]['syn'][$j];
                        if (check_word($syn_word) == true) {
                            ?>
                            <a target="_blank" style="text-decoration: underline;"
                               href="word.php?word=<?php echo $syn_word; ?>"><?php echo $syn_word; ?></a>
                        <?php
                        } else {
                            echo '<span class="link-clone">' . $syn_word . '</span>';
                        }
                        if ($j < sizeof($wordObj['defintion_arr'][$i]['syn']) - 1) {
                            echo ',';
                        }
                    }
                    ?>
                </label>
            <?php
            }
            ?>
            <?php
            if (sizeof($wordObj['defintion_arr'][$i]['sent']) > 0) {
                ?>
                <label>
                    <strong>Example Sentence</strong>
                    <ul>
                        <?php
                        for ($j = 0; $j < sizeof($wordObj['defintion_arr'][$i]['sent']); $j++)
                        {
                            $syn_word = $wordObj['defintion_arr'][$i]['sent'][$j];
                            ?>
                            <li><?php echo $syn_word; ?></li>
                        <?php
                        }
                        ?>
                    </ul>
                </label>
            <?php
            }
            ?>
        </div>
        <hr>
        <?php
        }
        ?>
        <div class="mnemonics">
            <label>
                <strong><u>Mnemonics (Memory Aids) for <?php echo $wordObj['word']; ?></u></strong>
                <ul class="user-added">
                    <?php
                    for ($i = 0; $i < sizeof($wordObj['mnemonics_arr']); $i++) {
                        if ($wordObj['mnemonics_arr'][$i]['addedBy'] == $_SESSION['userID']) {
                            ?>
                            <li>
                                <?php echo $wordObj['mnemonics_arr'][$i]['mnemonic']; ?>
                                <img src="resources/img/common/close.png" class="close delete-mnemonic" id="<?php echo $wordObj['mnemonics_arr'][$i]['mnemonicID']; ?>"/>
                            </li>
                        <?php
                        }
                    }
                    ?>
                </ul>
                <ul>
                    <hr>
                    <?php
                    for ($i = 0; $i < sizeof($wordObj['mnemonics_arr']); $i++) {
                        if ($wordObj['mnemonics_arr'][$i]['addedBy'] == NULL) {
                            ?>
                            <li><?php echo $wordObj['mnemonics_arr'][$i]['mnemonic']; ?></li>
                        <?php
                        }
                    }
                    ?>
                </ul>
                <?php
                if (Clearance::checkClearance(Clearance::$MODULE_MNEMONIC_ADD)) {
                    ?>
                    <div class="row">
                        <div class="large-9 small-10 columns">
                            <input type="text" class="mnemonic-data" placeholder="Add your own mnemonics."
                                   style="height:38px;"/>
                        </div>
                        <div class="large-3 small-2 columns">
                            <input type="button" value="Add" class="button secondary add-mnemonic"/>
                        </div>
                    </div>
                <?php
                }
                ?>
            </label>
        </div>
    </div>
</div>