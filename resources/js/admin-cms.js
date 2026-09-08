document.addEventListener('DOMContentLoaded', () => {
    initAccordions();
    initRepeaters();
    initLists();
    initLinks();
    initPackRows();
    initPricing();
    initImageModal();
    initImagePickers();
    initImageLists();
});

function initAccordions() {
    document.querySelectorAll('[data-accordion]').forEach((accordion) => {
        accordion.querySelectorAll('[data-accordion-trigger]').forEach((trigger) => {
            trigger.addEventListener('click', () => {
                const item = trigger.closest('[data-accordion-item]');
                const isOpen = item.classList.contains('is-open');
                const single = accordion.dataset.accordion === 'single';

                if (single) {
                    accordion.querySelectorAll('[data-accordion-item].is-open').forEach((open) => {
                        if (open !== item) {
                            open.classList.remove('is-open');
                            open.querySelector('[data-accordion-trigger]')?.setAttribute('aria-expanded', 'false');
                        }
                    });
                }

                item.classList.toggle('is-open', !isOpen);
                trigger.setAttribute('aria-expanded', String(!isOpen));
            });
        });
    });
}

function initRepeaters(scope = document) {
    scope.querySelectorAll('[data-repeater]').forEach((repeater) => {
        if (repeater.dataset.bound) return;
        repeater.dataset.bound = '1';

        const list = repeater.querySelector(':scope > [data-repeater-list], :scope > div > [data-repeater-list]');
        const template = repeater.querySelector('template[data-repeater-template]');
        if (!list || !template) return;

        repeater.querySelector(':scope > [data-repeater-add], :scope > button[data-repeater-add]')?.addEventListener('click', () => {
            const index = list.querySelectorAll('[data-repeater-item]').length;
            const html = template.innerHTML.replace(/__INDEX__/g, String(index));
            list.insertAdjacentHTML('beforeend', html);
            const newItem = list.lastElementChild;
            reindexRepeater(list);
            initRepeaters(newItem);
            initLists(newItem);
            initImagePickers(newItem);
            initImageLists(newItem);
            newItem?.classList.add('is-open');
        });

        repeater.addEventListener('click', (event) => {
            const removeBtn = event.target.closest('[data-repeater-remove]');
            if (removeBtn && repeater.contains(removeBtn)) {
                removeBtn.closest('[data-repeater-item]')?.remove();
                reindexRepeater(list);
                return;
            }

            const toggleBtn = event.target.closest('[data-repeater-toggle]');
            if (toggleBtn && repeater.contains(toggleBtn)) {
                toggleBtn.closest('[data-repeater-item]')?.classList.toggle('is-open');
            }
        });

        reindexRepeater(list);
    });
}

function reindexRepeater(list) {
    const baseName = list.dataset.repeaterList;
    list.querySelectorAll('[data-repeater-item]').forEach((item, index) => {
        item.querySelectorAll('[data-repeater-field]').forEach((field) => {
            const fieldKey = field.dataset.repeaterField;
            if (field.matches('input, textarea, select')) {
                field.name = `${baseName}[${index}][${fieldKey}]`;
            }
        });

        item.querySelectorAll('[data-nested-repeater]').forEach((nested) => {
            const nestedList = nested.querySelector('[data-repeater-list]');
            if (nestedList) {
                nestedList.dataset.repeaterList = `${baseName}[${index}][${nested.dataset.nestedRepeater}][items]`;
                reindexRepeater(nestedList);
            }
        });

        item.querySelectorAll('[data-nested-list]').forEach((nested) => {
            const imgList = nested.querySelector('[data-img-list]');
            if (imgList) {
                imgList.dataset.imgList = `${baseName}[${index}][${nested.dataset.nestedList}][items]`;
                reindexImageList(imgList);
                return;
            }

            const nestedList = nested.querySelector('[data-list]');
            if (nestedList) {
                nestedList.dataset.list = `${baseName}[${index}][${nested.dataset.nestedList}][items]`;
                reindexList(nestedList);
            }
        });

        item.querySelectorAll('[data-img-input][data-repeater-field]').forEach((input) => {
            input.name = `${baseName}[${index}][${input.dataset.repeaterField}]`;
        });

        const titleEl = item.querySelector('[data-repeater-title]');
        const titleField = item.querySelector('[data-repeater-field][data-title-source]');
        if (titleEl && titleField) {
            titleEl.textContent = titleField.value || `Item ${index + 1}`;
            titleField.addEventListener('input', () => {
                titleEl.textContent = titleField.value || `Item ${index + 1}`;
            });
        }
    });
}

function initLists(scope = document) {
    scope.querySelectorAll('[data-list-root]').forEach((root) => {
        if (root.dataset.bound) return;
        root.dataset.bound = '1';

        const list = root.querySelector('[data-list]');
        if (!list) return;

        root.querySelector('[data-list-add]')?.addEventListener('click', () => {
            const row = document.createElement('div');
            row.className = 'cms-list__row';
            row.innerHTML = `
                <input type="text" class="cms-input" data-list-field value="">
                <button type="button" class="cms-btn-icon cms-btn-icon--danger" data-list-remove title="Remover">×</button>
            `;
            list.appendChild(row);
            reindexList(list);
            row.querySelector('input')?.focus();
        });

        root.addEventListener('click', (event) => {
            if (event.target.closest('[data-list-remove]')) {
                event.target.closest('.cms-list__row')?.remove();
                reindexList(list);
            }
        });

        reindexList(list);
    });
}

function reindexList(list) {
    const baseName = list.dataset.list;
    list.querySelectorAll('.cms-list__row').forEach((row, index) => {
        row.querySelectorAll('[data-list-field]').forEach((field) => {
            field.name = `${baseName}[${index}]`;
        });
    });
}

function initLinks() {
    document.querySelectorAll('[data-links-root]').forEach((root) => {
        const list = root.querySelector('[data-links-list]');
        if (!list) return;

        root.querySelector('[data-links-add]')?.addEventListener('click', () => {
            const index = list.querySelectorAll('[data-links-item]').length;
            const baseName = list.dataset.linksList;
            const row = document.createElement('div');
            row.className = 'cms-links__row';
            row.dataset.linksItem = '';
            row.innerHTML = `
                <input type="text" class="cms-input" name="${baseName}[${index}][label]" placeholder="Texto do link">
                <input type="text" class="cms-input" name="${baseName}[${index}][url]" placeholder="/pagina">
                <button type="button" class="cms-btn-icon cms-btn-icon--danger" data-links-remove title="Remover">×</button>
            `;
            list.appendChild(row);
            row.querySelector('input')?.focus();
        });

        root.addEventListener('click', (event) => {
            if (event.target.closest('[data-links-remove]')) {
                event.target.closest('[data-links-item]')?.remove();
                reindexLinks(list);
            }
        });
    });
}

function reindexLinks(list) {
    const baseName = list.dataset.linksList;
    list.querySelectorAll('[data-links-item]').forEach((row, index) => {
        const inputs = row.querySelectorAll('input');
        if (inputs[0]) inputs[0].name = `${baseName}[${index}][label]`;
        if (inputs[1]) inputs[1].name = `${baseName}[${index}][url]`;
    });
}

function initPackRows() {
    document.querySelectorAll('[data-pack-rows]').forEach((root) => {
        const list = root.querySelector('[data-pack-rows-list]');
        const rowTemplate = root.querySelector('template[data-pack-row-template]');
        const cellTemplate = root.querySelector('template[data-pack-cell-template]');
        if (!list || !rowTemplate || !cellTemplate) return;

        root.querySelector('[data-pack-row-add]')?.addEventListener('click', () => {
            const rowIndex = list.querySelectorAll('[data-pack-row]').length;
            const html = rowTemplate.innerHTML.replace(/__ROW__/g, String(rowIndex));
            list.insertAdjacentHTML('beforeend', html);
            const row = list.lastElementChild;
            row?.classList.add('is-open');
            bindPackRow(row, cellTemplate);
        });

        list.querySelectorAll('[data-pack-row]').forEach((row) => bindPackRow(row, cellTemplate));

        list.addEventListener('click', (event) => {
            const removeRow = event.target.closest('[data-pack-row-remove]');
            if (removeRow) {
                removeRow.closest('[data-pack-row]')?.remove();
                reindexPackRows(list);
                return;
            }

            const toggleRow = event.target.closest('[data-pack-row-toggle]');
            if (toggleRow) {
                toggleRow.closest('[data-pack-row]')?.classList.toggle('is-open');
            }
        });
    });
}

function bindPackRow(row, cellTemplate) {
    if (!row || row.dataset.bound) return;
    row.dataset.bound = '1';

    const cellsList = row.querySelector('[data-pack-cells]');
    const baseName = row.closest('[data-pack-rows-list]')?.dataset.packRowsList;

    row.querySelector('[data-pack-cell-add]')?.addEventListener('click', () => {
        const rowIndex = [...row.parentElement.children].indexOf(row);
        const cellIndex = cellsList.querySelectorAll('[data-pack-cell]').length;
        const html = cellTemplate.innerHTML
            .replace(/__ROW__/g, String(rowIndex))
            .replace(/__CELL__/g, String(cellIndex));
        cellsList.insertAdjacentHTML('beforeend', html);
        reindexPackRows(row.closest('[data-pack-rows-list]'));
        initImagePickers(cellsList.lastElementChild);
    });

    cellsList?.addEventListener('click', (event) => {
        if (event.target.closest('[data-pack-cell-remove]')) {
            event.target.closest('[data-pack-cell]')?.remove();
            reindexPackRows(row.closest('[data-pack-rows-list]'));
        }
    });

    cellsList?.addEventListener('change', (event) => {
        if (event.target.matches('[data-pack-cell-type]')) {
            const cell = event.target.closest('[data-pack-cell]');
            cell?.querySelector('[data-pack-cell-text]')?.classList.toggle('hidden', event.target.value !== 'text');
            cell?.querySelector('[data-pack-cell-image]')?.classList.toggle('hidden', event.target.value !== 'image');
        }
    });

    reindexPackRows(row.closest('[data-pack-rows-list]'));
}

function reindexPackRows(list) {
    if (!list) return;
    const baseName = list.dataset.packRowsList;

    list.querySelectorAll('[data-pack-row]').forEach((row, rowIndex) => {
        row.querySelector('[data-pack-row-label]')?.replaceChildren(document.createTextNode(`Linha ${rowIndex + 1}`));

        row.querySelectorAll('[data-pack-cell]').forEach((cell, cellIndex) => {
            const prefix = `${baseName}[${rowIndex}][cells][${cellIndex}]`;
            const typeSelect = cell.querySelector('[data-pack-cell-type]');
            if (typeSelect) typeSelect.name = `${prefix}[type]`;

            cell.querySelectorAll('[data-pack-cell-text] [data-field]').forEach((field) => {
                field.name = `${prefix}[${field.dataset.field}]`;
            });
            cell.querySelectorAll('[data-pack-cell-image] [data-field]').forEach((field) => {
                field.name = `${prefix}[${field.dataset.field}]`;
            });
        });
    });
}

function initPricing() {
    document.querySelectorAll('[data-pricing]').forEach((root) => {
        const gendersList = root.querySelector('[data-pricing-genders]');
        const sectionTemplate = root.querySelector('template[data-pricing-section-template]');
        const itemTemplate = root.querySelector('template[data-pricing-item-template]');
        if (!gendersList) return;

        gendersList.querySelectorAll('[data-pricing-gender]').forEach((gender) => {
            bindPricingGender(gender, sectionTemplate, itemTemplate);
        });

        gendersList.addEventListener('click', (event) => {
            const addSection = event.target.closest('[data-pricing-section-add]');
            if (addSection) {
                const gender = addSection.closest('[data-pricing-gender]');
                const sectionsList = gender.querySelector('[data-pricing-sections]');
                const genderIndex = [...gendersList.children].indexOf(gender);
                const sectionIndex = sectionsList.querySelectorAll('[data-pricing-section]').length;
                const html = sectionTemplate.innerHTML
                    .replace(/__G__/g, String(genderIndex))
                    .replace(/__S__/g, String(sectionIndex));
                sectionsList.insertAdjacentHTML('beforeend', html);
                bindPricingSection(sectionsList.lastElementChild, itemTemplate, genderIndex, sectionIndex);
                sectionsList.lastElementChild?.classList.add('is-open');
                return;
            }

            const removeSection = event.target.closest('[data-pricing-section-remove]');
            if (removeSection) {
                removeSection.closest('[data-pricing-section]')?.remove();
                reindexPricing(gendersList);
                return;
            }

            const toggleSection = event.target.closest('[data-pricing-section-toggle]');
            if (toggleSection) {
                toggleSection.closest('[data-pricing-section]')?.classList.toggle('is-open');
                return;
            }

            const addItem = event.target.closest('[data-pricing-item-add]');
            if (addItem) {
                const section = addItem.closest('[data-pricing-section]');
                const itemsList = section.querySelector('[data-pricing-items]');
                const genderIndex = [...gendersList.children].indexOf(section.closest('[data-pricing-gender]'));
                const sectionIndex = [...section.parentElement.children].indexOf(section);
                const itemIndex = itemsList.querySelectorAll('[data-pricing-item]').length;
                const html = itemTemplate.innerHTML
                    .replace(/__G__/g, String(genderIndex))
                    .replace(/__S__/g, String(sectionIndex))
                    .replace(/__I__/g, String(itemIndex));
                itemsList.insertAdjacentHTML('beforeend', html);
                reindexPricing(gendersList);
                return;
            }

            const removeItem = event.target.closest('[data-pricing-item-remove]');
            if (removeItem) {
                removeItem.closest('[data-pricing-item]')?.remove();
                reindexPricing(gendersList);
            }
        });
    });
}

function bindPricingGender(gender, sectionTemplate, itemTemplate) {
    gender.querySelectorAll('[data-pricing-section]').forEach((section, sectionIndex) => {
        const genderIndex = [...gender.parentElement.children].indexOf(gender);
        bindPricingSection(section, itemTemplate, genderIndex, sectionIndex);
    });
    reindexPricing(gender.closest('[data-pricing-genders]'));
}

function bindPricingSection(section, itemTemplate, genderIndex, sectionIndex) {
    if (!section || section.dataset.bound) return;
    section.dataset.bound = '1';
    reindexPricing(section.closest('[data-pricing-genders]'));
}

function reindexPricing(gendersList) {
    if (!gendersList) return;
    const baseName = gendersList.dataset.pricingGenders;

    gendersList.querySelectorAll('[data-pricing-gender]').forEach((gender, gIndex) => {
        gender.querySelectorAll('[data-pricing-field]').forEach((field) => {
            field.name = `${baseName}[${gIndex}][${field.dataset.pricingField}]`;
        });

        gender.querySelectorAll('[data-pricing-section]').forEach((section, sIndex) => {
            section.querySelector('[data-pricing-section-title]')?.replaceChildren(
                document.createTextNode(section.querySelector('[data-pricing-section-name]')?.value || `Secção ${sIndex + 1}`),
            );

            section.querySelectorAll('[data-pricing-section-field]').forEach((field) => {
                field.name = `${baseName}[${gIndex}][sections][${sIndex}][${field.dataset.pricingSectionField}]`;
            });

            section.querySelectorAll('[data-pricing-item]').forEach((item, iIndex) => {
                item.querySelectorAll('[data-pricing-item-field]').forEach((field) => {
                    field.name = `${baseName}[${gIndex}][sections][${sIndex}][items][${iIndex}][${field.dataset.pricingItemField}]`;
                });
            });
        });
    });
}

function resolveImageUrl(path) {
    if (!path) return '';
    if (path.startsWith('http://') || path.startsWith('https://')) return path;
    if (path.startsWith('images/')) return `/${path}`;
    if (path.includes('/')) return `/storage/${path}`;
    return `/images/${path}`;
}

let activeImageInput = null;

function initImageModal() {
    const modal = document.querySelector('[data-img-modal]');
    if (!modal || modal.dataset.bound) return;
    modal.dataset.bound = '1';

    modal.querySelectorAll('[data-img-modal-close]').forEach((btn) => {
        btn.addEventListener('click', closeImageModal);
    });

    modal.addEventListener('click', (event) => {
        const selectBtn = event.target.closest('[data-img-select]');
        if (selectBtn && activeImageInput) {
            setPickerValue(activeImageInput.closest('[data-img-picker]'), selectBtn.dataset.imgSelect);
            closeImageModal();
            return;
        }
    });

    modal.querySelector('[data-img-modal-upload]')?.addEventListener('change', async (event) => {
        const file = event.target.files?.[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('file', file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

        try {
            const response = await fetch(modal.dataset.uploadUrl, {
                method: 'POST',
                headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: formData,
            });

            if (!response.ok) throw new Error('Upload failed');

            const data = await response.json();
            const library = modal.querySelector('[data-img-modal-library]');
            if (library) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'cms-img-picker__thumb';
                btn.dataset.imgSelect = data.path;
                btn.title = data.filename;
                btn.innerHTML = `<img src="${data.url}" alt="">`;
                library.prepend(btn);
            }

            if (activeImageInput) {
                setPickerValue(activeImageInput.closest('[data-img-picker]'), data.path);
                closeImageModal();
            }
        } catch {
            alert('Não foi possível carregar a imagem. Tenta novamente.');
        }

        event.target.value = '';
    });
}

function openImageModal(input) {
    const modal = document.querySelector('[data-img-modal]');
    if (!modal || !input) return;
    activeImageInput = input;
    modal.classList.remove('hidden');
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('cms-modal-open');
}

function closeImageModal() {
    const modal = document.querySelector('[data-img-modal]');
    if (!modal) return;
    activeImageInput = null;
    modal.classList.add('hidden');
    modal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('cms-modal-open');
}

function setPickerValue(picker, path) {
    if (!picker) return;
    const input = picker.querySelector('[data-img-input]');
    const frame = picker.querySelector('[data-img-frame]');
    if (!input || !frame) return;

    input.value = path;

    if (!path) {
        frame.innerHTML = `
            <button type="button" class="cms-img-picker__empty" data-img-replace>
                <span class="cms-img-picker__empty-icon">+</span>
                <span>Escolher imagem</span>
            </button>`;
        bindImagePicker(picker);
        return;
    }

    const url = resolveImageUrl(path);
    frame.innerHTML = `
        <img src="${url}" alt="" class="cms-img-picker__img" data-img-preview>
        <div class="cms-img-picker__actions">
            <button type="button" class="cms-img-picker__btn" data-img-replace>Substituir</button>
            <button type="button" class="cms-img-picker__btn cms-img-picker__btn--ghost" data-img-remove>Remover</button>
        </div>`;
    bindImagePicker(picker);
    input.dispatchEvent(new Event('change', { bubbles: true }));
}

function bindImagePicker(picker) {
    picker.querySelector('[data-img-replace]')?.addEventListener('click', () => {
        openImageModal(picker.querySelector('[data-img-input]'));
    });
    picker.querySelector('[data-img-remove]')?.addEventListener('click', () => {
        setPickerValue(picker, '');
    });
}

function initImagePickers(scope = document) {
    scope.querySelectorAll('[data-img-picker]').forEach((picker) => {
        if (picker.dataset.bound) return;
        picker.dataset.bound = '1';
        bindImagePicker(picker);
    });
}

function initImageLists(scope = document) {
    scope.querySelectorAll('[data-img-list-root]').forEach((root) => {
        if (root.dataset.bound) return;
        root.dataset.bound = '1';

        const list = root.querySelector('[data-img-list]');
        const template = document.querySelector('[data-img-list-template]');
        if (!list) return;

        root.querySelector('[data-img-list-add]')?.addEventListener('click', () => {
            if (template) {
                list.appendChild(template.content.cloneNode(true));
            } else {
                const item = document.createElement('div');
                item.className = 'cms-img-list__item';
                item.dataset.imgListItem = '';
                item.innerHTML = `
                    <div class="cms-img-picker" data-img-picker>
                        <input type="hidden" value="" data-img-input>
                        <div class="cms-img-picker__frame" data-img-frame>
                            <button type="button" class="cms-img-picker__empty" data-img-replace>
                                <span class="cms-img-picker__empty-icon">+</span>
                                <span>Escolher imagem</span>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="cms-img-list__remove" data-img-list-remove title="Remover">×</button>`;
                list.appendChild(item);
            }
            reindexImageList(list);
            initImagePickers(list.lastElementChild);
        });

        root.addEventListener('click', (event) => {
            if (event.target.closest('[data-img-list-remove]')) {
                const items = list.querySelectorAll('[data-img-list-item]');
                if (items.length <= 1) {
                    setPickerValue(items[0]?.querySelector('[data-img-picker]'), '');
                    return;
                }
                event.target.closest('[data-img-list-item]')?.remove();
                reindexImageList(list);
            }
        });

        reindexImageList(list);
    });
}

function reindexImageList(list) {
    const baseName = list.dataset.imgList;
    list.querySelectorAll('[data-img-list-item]').forEach((item, index) => {
        const input = item.querySelector('[data-img-input]');
        if (input) input.name = `${baseName}[${index}]`;
    });
}
