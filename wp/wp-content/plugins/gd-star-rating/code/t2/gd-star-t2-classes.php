<?php

class gdTemplateElement {
    var $tag;
    var $description;
    var $tpl;

    function gdTemplateElement($t, $d) {
        $this->tag = $t;
        $this->description = $d;
        $this->tpl = -1;
    }
}

class gdTemplatePart {
    var $name;
    var $code;
    var $description;
    var $elements;
    var $size;

    function gdTemplatePart($n, $c, $d, $s = "single") {
        $this->name = $n;
        $this->code = $c;
        $this->description = $d;
        $this->size = $s;
        $this->elements = array();
    }
}

class gdTemplateTpl {
    var $code;
    var $tag;
    
    function gdTemplateTpl($c, $t) {
        $this->code = $c;
        $this->tag = $t;
    }
}

class gdTemplate {
    var $code;
    var $section;
    var $elements;
    var $parts;
    var $tag;
    var $tpls;
    var $tpls_tags;

    function gdTemplate($c, $s, $t = "") {
        $this->code = $c;
        $this->section = $s;
        $this->tag = $t;
        $this->elements = array();
        $this->parts = array();
        $this->tpls = array();
        $this->tpls_tags = array();
    }

    function add_template($c, $t) {
        $this->tpls[] = new gdTemplateTpl($c, $t);
        $this->tpls_tags[] = $t;
    }

    function add_element($t, $d) {
        $tpl = new gdTemplateElement($t, $d);
        if (in_array($t, $this->tpls_tags)) {
            $k = array_keys($this->tpls_tags, $t);
            if (count($k) == 1) $tpl->tpl = $k[0];
        }
        $this->elements[] = $tpl;
    }
    
    function add_part($n, $c, $d, $parts = array(), $s = "single") {
        $part = new gdTemplatePart($n, $c, $d, $s);
        $part->elements = $parts;
        $this->parts[] = $part;
    }
}

class gdTemplates {
    var $tpls;

    function gdTemplates() {
        $this->tpls = array();
    }

    function add_template($t) {
        $this->tpls[] = $t;
    }

    function get_list($section) {
        foreach ($this->tpls as $t) {
            if ($t->code == $section) return $t;
        }
        return null;
    }

    function list_sections() {
        $sections = array();
        $listed = array();
        foreach ($this->tpls as $t) {
            $code = $t->code;
            $name = $t->section;
            if (!in_array($code, $listed)) {
                $listed[] = $code;
                $sections[] = array("code" => $code, "name" => $name);
            }
        }
        return $sections;
    }

    function find_template_tag($code) {
        $tag = "";
        foreach ($this->tpls as $t) {
            if ($t->code == $code) {
                $tag = $t->tag;
                break;
            }
        }
        return $tag;
    }

    function list_sections_assoc() {
        $sections = array();
        $listed = array();
        foreach ($this->tpls as $t) {
            $code = $t->code;
            $name = $t->section;
            if (!in_array($code, $listed)) {
                $listed[] = $code;
                $sections[$code] = $name;
            }
        }
        return $sections;
    }
}

class gdTemplateRender {
    var $tpl;
    var $dep;
    var $elm;
    var $tag;

    function gdTemplateRender($id, $section) {
        $this->tpl = wp_gdsr_get_template($id);
        if (!is_object($this->tpl) || $this->tpl->section != $section) {
            $t = GDSRDB::get_templates($section, true, true);
            $id = $t->template_id;
            $this->tpl = wp_gdsr_get_template($id);
        }
        $this->dep = array();

        $dependencies = unserialize($this->tpl->dependencies);
        if (is_array($dependencies)) {
            foreach ($dependencies as $key => $value) $this->dep[$key] = new gdTemplateRender($value, $key);
        }
        $this->elm = unserialize($this->tpl->elements);
        if (is_array($this->elm)) {
            foreach($this->elm as $key => $value) {
                preg_match_all('(%.+?%)', $value, $matches, PREG_PATTERN_ORDER);
                $this->tag[$key] = $matches[0];
            }
        }
    }
}

function wp_gdsr_get_template($template_id) {
    return GDSRDB::get_template($template_id);
}

?>
