<?php
if(!isset($_SESSION['user'])) header('Location: index.php');
?>
<div class="ide-form my-back error myswitch" style="color:white;padding:1%;">
<?php echo $_SESSION['error'];?>
</div>
<form action="index.php#c_output" method="post" class="ide-form myswitch" spellcheck="false">
    <label for="c_code">Code</label><br><br>
    <textarea name="c_code" class="code-area my-back" onkeydown="if(event.keyCode===9){var v=this.value,s=this.selectionStart,e=this.selectionEnd;this.value=v.substring(0, s)+'\t'+v.substring(e);this.selectionStart=this.selectionEnd=s+1;return false;}"><?php echo $c_code;?></textarea>
    <div class="clear-both"></div>
    <br><br>
    <div>
    <?php if($_SESSION['user']!=''){?>
        <div class="save-area">
        <label for="save-name">Name for File</label><input type="text" name="save-name" id="save-name" value="<?php echo $save_name;?>">
        <label for="save">Save File</label><input type="checkbox" name="save" value="save" id="save" <?php echo $check;?> >  <br>
        </div>
        <?php }?>
        <div class="input-prop">
            <label for="c_input">Input</label><br><br>
            <textarea name="c_input" id="c_input" class="input-area my-back"><?php echo $c_input;?></textarea>
        </div>
        <div class="submit-area">
            <input type="submit" class="submit-button my-back" name="submit" value="submit"> 
        </div>
        <div class="clear-both"></div>
    </div>
</form>
<div class="ide-form myswitch" >
    <label for="c_output">Output</label><br><br>
    <textarea readonly name="c_output" id="c_output" class="output-area my-back" ><?php echo $c_output;?></textarea>
</div>