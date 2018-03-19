<?php

class Template
{
    private $entries = array();
    public $template;

    // Manage the rendering of the template by replacing the keys with the values passed.
    public function render()
    {
        $template = $this->template;
        $content = file_get_contents($template);
        $content = $this->replace($content, $this->entries);
        $content = preg_replace('~\{\{\#each +(\w+)\}\}~', '<?php foreach ($this->entries[\'$1\'] as $entry){ echo $this->replace(\'', $content);
        
        /* $content = preg_replace('~\{\{\#unless @last\}\}~', '<?php echo this->checkLast($entry); ?>', $content); */ 
        /* $content = preg_replace('~\{\{\/unless\}\}~', '\', $entry); } ?>', $content); */
        $content = preg_replace('~\{\{\/each\}\}~', '\', $entry); } ?>', $content);
        $content = preg_replace('~\{\{\#unless @+(\w+)\}\}(.+){{else}}(.+)\{\{\/unless\}\}~', '<?php echo $this->replaceCond($1,$2,$3,$entry); ?>', $content);
        eval(' ?>' . $content . '<?php ');
    }

    // Replace the keys (with double curly brakets) with values inside the template.
    private function replace($content, $entries)
    {
        foreach ($entries as $key => $value) {
            if (!is_array($entries[$key])) {
                $delimiter = '{{' . $key . '}}';
                $content = str_replace($delimiter, $value, $content);
            }
        }

        return $content;
    }

    private function replaceCond($condition, $val2, $val3, $entry)
    {
        if ($condition == 'last') {

            $entries = $this->entries;
            end($entries);
            $lastEl = key($entries);
            foreach($entries as $arr_entry){
                if ($arr_entry !== $lastEl) {
                    return $val2;
                } else {
                    return $val3;
                }   
            }

            
           
        }
    }
    
    // Add the entries to be parsed to the local variable $entries.
    public function assign($key, $value)
    {
        $this->entries[$key] = $value;
    }


    // Add template function
    public function setTemplate($template)
    {
        $this->template = $template;
    }
}
