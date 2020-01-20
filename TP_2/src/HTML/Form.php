<?php

namespace App\HTML;

class Form
{
    private $data;

    private $errors;

    public function __construct(array $data, array $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    public function input(string $label, string $name)
    {
        $value = isset($_POST[$name]) ? $_POST[$name] : $this->data[$name];
        $cond = isset($this->errors[$name]) ? 'is-invalid' : '';
        $i = isset($this->errors[$name]) ? implode('<br>', $this->errors[$name]) : '';
        $cond2 = isset($this->errors[$name]) ? "<div class='invalid-feedback'>{$i}</div>" : "";
        $condDate = ($name === "date") ? "disabled='true'" : null;
        $type = ($name == 'password') ? 'password' : 'text';
        return  <<<HTML
        <div class="form-group">
            <label for="{$name}">{$label}</label>
            <input type="{$type}" name="{$name}" id="{$name}" class="form-control {$cond}" value="{$value}" {$condDate} required>
            {$cond2}
        </div>
HTML;
    }

    public function select(string $key, string $label, array $options = [], array $categoriesID_post): string
    {
        $options_html = '';
        foreach ($options as $k => $v) {
            $selected = (!empty($categoriesID_post) and in_array($k, $categoriesID_post)) ? 'selected' : '';
            $options_html .= "<option value='{$k}' $selected>{$v}</option>";
        }

        return  <<<HTML
        <div class="form-group">
            <label for="{$key}">{$label}</label>
            <select name="{$key}[]" id="{$key}" class="form-control" required multiple>
            $options_html
            </select>
        </div>
HTML;
    }
    public function textArea(string $label, string $name)
    {
        $value = isset($_POST[$name]) ? $_POST[$name] : $this->data[$name];
        $cond = isset($this->errors[$name]) ? 'is-invalid' : '';
        $i = isset($this->errors[$name]) ? implode('<br>', $this->errors[$name]) : '';
        $cond2 = isset($this->errors[$name]) ? "<div class='invalid-feedback'>{$i}</div>" : "";

        return  <<<HTML
        <div class="form-group">
            <label for="{$name}">{$label}</label>
            <textArea name="{$name}" id="{$name}" class="form-control {$cond}" rows="5">{$value}</textArea>
            {$cond2}
        </div>
HTML;
    }

    public function submit(string $label)
    {
        return <<<HTML
        <button type="submit" class="btn btn-primary">{$label}</button>
HTML;
    }
}

















/* <div class="form-group">
        <label for="name">Le Nom </label>
        <input type="text" name="name" id="name" value="<?= isset($_POST['name']) ? $_POST['name'] : ($post->getName()) ?>" class="form-control  <?= isset($errors['name']) ? 'is-invalid' : ''  ?>">
        <?php if (isset($errors['name'])) : ?>
            <div class="invalid-feedback">
                <?= implode('<br>', $errors['name']) ?>
            </div>
        <?php endif; ?>
    </div> */
