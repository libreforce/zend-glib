<?php echo $this->render('licence.tpl') ?>

<?php
  //echo $this->inclusionGuardBegin($fileGenerator);
#ifndef __DOM_NODE_H__
#define __DOM_NODE_H__
?>

G_BEGIN_DECLS

<?php echo $this->content;
/*

echo $this->typeDeclaration($gobject);

foreach ($this->gobjects as $gobject) {
    echo $this->typeDeclaration($gobject);
    echo $this->methodDefinitions($gobject);
}

*/ ?>

G_END_DECLS

<?php //echo $this->inclusionGuardEnd($fileGenerator);
#endif /* __DOM_NODE_H__ */
?>
