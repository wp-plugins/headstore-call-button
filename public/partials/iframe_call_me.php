<?php

$attr_campaign_id = ($campaign_id && $campaign_id != '') ? 'data-campaign="'.$campaign_id.'"' : '';
$name_data_type = ($type == 'COMPANY_GROUP' ) ? 'group' : 'expert';

?>

<!--script src="//app.headstore.com/callme/callme.js"></script-->
<div class="display-iframe">
<div class="callme-button" data-<?php echo $name_data_type; ?>="<?php echo $group_or_expert_id; ?>" data-design="<?php echo $design; ?>" <?php echo $attr_campaign_id; ?>></div>
</div>