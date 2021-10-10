document.addEventListener('DOMContentLoaded', function($) { 
    let form_settings = document.querySelector('#settings-form');

    form_settings.addEventListener('submit', function (e) {
        reset_errors();

        let data = {
            position_xs: form_settings.querySelector('#position_xs').value,
            position_sm: form_settings.querySelector('#position_sm').value,
            position_md: form_settings.querySelector('#position_md').value,
            position_lg: form_settings.querySelector('#position_lg').value,
            position_xl: form_settings.querySelector('#position_xl').value,
            position_xs_unit: form_settings.querySelector('#position_xs_unit').value,
            position_sm_unit: form_settings.querySelector('#position_sm_unit').value,
            position_md_unit: form_settings.querySelector('#position_md_unit').value,
            position_lg_unit: form_settings.querySelector('#position_lg_unit').value,
            position_xl_unit: form_settings.querySelector('#position_xl_unit').value,
            thickness: form_settings.querySelector('#thickness').value,
            thickness_unit: form_settings.querySelector('#thickness_unit').value,
            color: form_settings.querySelector('#color').value,
            z_index: form_settings.querySelector('#z_index').value,
        };

        let errors = validate(data, rules);

        if (errors.length > 0) {
            e.preventDefault();

            let error_elem = document.querySelector('.form-errors');
            errors.forEach(error => create_error(error, error_elem));

            let close_buttons = error_elem.querySelectorAll('.notice-dismiss');
            close_buttons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    let ancestor = this.closest('.is-dismissible');
                    if (ancestor) {
                        ancestor.remove();
                    }
                })
            })
        }
    });
});

function create_error(error, parent_element) {
    if (!parent_element || !error) return;

    let wrapper = document.createElement('div');
    wrapper.classList.add('notice', 'notice-error', 'settings-error', 'is-dismissible');

    let message_para = document.createElement('p');
    message_para.innerHTML = `<strong>${error}</strong>`;
    
    let close_button = document.createElement('button');
    close_button.classList.add('notice-dismiss');
    close_button.setAttribute('type', 'button');

    close_button.innerHTML = `<span class="screen-reader-text">Dismiss this notice.</span>`;

    wrapper.appendChild(message_para);
    wrapper.appendChild(close_button);

    parent_element.appendChild(wrapper);
}

function reset_errors() {
    let elems = document.querySelectorAll('.settings-error');
    elems.forEach(elem => elem.remove());
}

function validate(data, rules = {}, labels = {}) {
    let errors = [];

    Object.keys(rules).forEach(key => {
        let rule_values = rules[key];
        let value = data[key];
        let label = labels[key] ?? key;

        if (rule_values['required'] && !value) {
            errors.push(`${label} is required.`);
        }
        else if (value && rule_values['numeric'] && !is_numeric(value)) {
            errors.push(`${label} must be numeric.`);
        }
    });

    return errors;
}

function is_numeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

const rules = {
    position_xs: {numeric: true},
    position_sm: {numeric: true},
    position_md: {numeric: true},
    position_lg: {numeric: true},
    position_xl: {numeric: true},
    thickness: {numeric: true},
    z_index: {numeric:true}
}