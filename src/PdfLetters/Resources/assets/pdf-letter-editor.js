(function () {
    function boot(root) {
        const payloadNode = root.querySelector('.dg-pdf-editor__payload');
        if (!payloadNode) return;

        const state = JSON.parse(payloadNode.textContent || '{}');
        state.fields = Array.isArray(state.fields) ? state.fields : [];
        state.pages = Array.isArray(state.pages) ? state.pages : [];
        state.availableFields = Array.isArray(state.availableFields) ? state.availableFields : [];
        state.currentPage = state.pages[0] ? state.pages[0].number : 1;
        state.selectedFieldId = state.fields[0] ? state.fields[0].id || '__new_0' : null;

        const saveButton = root.querySelector('.dg-pdf-editor__save');
        const removeButton = root.querySelector('.dg-pdf-editor__remove');
        const pageNav = root.querySelector('.dg-pdf-editor__pages-nav');
        const palette = root.querySelector('.dg-pdf-editor__fields-palette');
        const pagesWrap = root.querySelector('.dg-pdf-editor__pages');
        const form = root.querySelector('.dg-pdf-editor__form');
        const status = document.createElement('div');
        status.className = 'dg-pdf-editor__status';
        root.querySelector('.dg-pdf-editor__sidebar').appendChild(status);

        function fieldKey(field, index) {
            return field.id || field._clientId || ('__new_' + index);
        }

        function normalizeColor(color) {
            if (!color) return '#000000';
            if (color.charAt(0) === '#') return color;
            const parts = color.split(',').map(Number);
            if (parts.length !== 3) return '#000000';
            return '#' + parts.map(function (value) {
                const safe = Math.max(0, Math.min(255, value || 0));
                return safe.toString(16).padStart(2, '0');
            }).join('');
        }

        function serializeColor(color) {
            const normalized = normalizeColor(color).replace('#', '');
            return [
                parseInt(normalized.substring(0, 2), 16),
                parseInt(normalized.substring(2, 4), 16),
                parseInt(normalized.substring(4, 6), 16)
            ].join(',');
        }

        function getSelectedField() {
            return state.fields.find(function (field, index) {
                return fieldKey(field, index) === state.selectedFieldId;
            }) || null;
        }

        function countForField(name) {
            return state.fields.filter(function (field) { return field.field === name; }).length;
        }

        function renderPageNav() {
            pageNav.innerHTML = '';
            state.pages.forEach(function (page) {
                const button = document.createElement('button');
                button.type = 'button';
                button.textContent = 'Page ' + page.number;
                if (page.number === state.currentPage) button.classList.add('is-active');
                button.addEventListener('click', function () {
                    state.currentPage = page.number;
                    renderAll();
                });
                pageNav.appendChild(button);
            });
        }

        function renderPalette() {
            palette.innerHTML = '';
            state.availableFields.forEach(function (group) {
                const wrap = document.createElement('div');
                wrap.className = 'dg-pdf-editor__palette-group';
                const title = document.createElement('h3');
                title.textContent = group.label || group.name;
                wrap.appendChild(title);

                (group.fields || []).forEach(function (fieldDefinition) {
                    const row = document.createElement('div');
                    row.className = 'dg-pdf-editor__palette-item';
                    const meta = document.createElement('div');
                    meta.innerHTML = '<strong>' + (fieldDefinition.label || fieldDefinition.name) + '</strong><br><small>' + countForField(fieldDefinition.name) + ' placed</small>';

                    const button = document.createElement('button');
                    button.type = 'button';
                    button.textContent = 'Add';
                    button.addEventListener('click', function () {
                        const page = state.pages.find(function (item) { return item.number === state.currentPage; }) || state.pages[0];
                        const next = {
                            _clientId: String(Date.now()) + Math.random(),
                            field: fieldDefinition.name,
                            label: fieldDefinition.label || fieldDefinition.name,
                            type: fieldDefinition.type || null,
                            x: page ? page.width / 2 : 40,
                            y: page ? page.height / 2 : 40,
                            page: state.currentPage,
                            size: 12,
                            align: 'left',
                            color: '0,0,0',
                            textTransform: ''
                        };
                        state.fields.push(next);
                        state.selectedFieldId = fieldKey(next, state.fields.length - 1);
                        renderAll();
                    });

                    row.appendChild(meta);
                    row.appendChild(button);
                    wrap.appendChild(row);
                });
                palette.appendChild(wrap);
            });
        }

        function renderPages() {
            pagesWrap.innerHTML = '';
            state.pages.forEach(function (page) {
                const pageNode = document.createElement('section');
                pageNode.className = 'dg-pdf-editor__page';
                pageNode.style.width = '900px';
                pageNode.style.height = ((900 / page.width) * page.height) + 'px';
                pageNode.dataset.page = String(page.number);

                const iframe = document.createElement('iframe');
                iframe.src = (state.pdfSource || '') + '#page=' + page.number + '&toolbar=0&navpanes=0&scrollbar=0';

                const overlay = document.createElement('div');
                overlay.className = 'dg-pdf-editor__overlay';

                state.fields.forEach(function (field, index) {
                    if ((field.page || 1) !== page.number) return;
                    const node = document.createElement('button');
                    node.type = 'button';
                    node.className = 'dg-pdf-editor__field';
                    if (fieldKey(field, index) === state.selectedFieldId) node.classList.add('is-selected');
                    node.textContent = field.label || field.field;
                    node.style.left = ((field.x / page.width) * 100) + '%';
                    node.style.top = ((field.y / page.height) * 100) + '%';
                    node.style.color = normalizeColor(field.color);
                    node.style.fontSize = (field.size || 12) + 'px';
                    node.dataset.key = fieldKey(field, index);
                    node.addEventListener('click', function () {
                        state.selectedFieldId = node.dataset.key;
                        renderAll();
                    });
                    bindDragging(node, overlay, page, field);
                    overlay.appendChild(node);
                });

                pageNode.appendChild(iframe);
                pageNode.appendChild(overlay);
                pagesWrap.appendChild(pageNode);
            });
        }

        function bindDragging(node, overlay, page, field) {
            let dragging = false;

            node.addEventListener('pointerdown', function (event) {
                dragging = true;
                node.setPointerCapture(event.pointerId);
            });

            node.addEventListener('pointerup', function (event) {
                dragging = false;
                node.releasePointerCapture(event.pointerId);
            });

            node.addEventListener('pointermove', function (event) {
                if (!dragging) return;
                const rect = overlay.getBoundingClientRect();
                const x = Math.max(0, Math.min(rect.width, event.clientX - rect.left));
                const y = Math.max(0, Math.min(rect.height, event.clientY - rect.top));
                field.x = Number(((x / rect.width) * page.width).toFixed(2));
                field.y = Number(((y / rect.height) * page.height).toFixed(2));
                field.page = page.number;
                renderForm();
                renderPages();
            });
        }

        function renderForm() {
            const field = getSelectedField();
            Array.from(form.elements).forEach(function (element) {
                if (!element.name) return;
                if (!field) {
                    element.value = '';
                    element.disabled = true;
                    return;
                }
                element.disabled = false;
                if (element.name === 'color') {
                    element.value = normalizeColor(field.color);
                    return;
                }
                element.value = field[element.name] == null ? '' : field[element.name];
            });
        }

        function renderAll() {
            renderPageNav();
            renderPalette();
            renderPages();
            renderForm();
            status.textContent = '';
        }

        form.addEventListener('input', function (event) {
            const field = getSelectedField();
            if (!field || !event.target.name) return;
            const name = event.target.name;
            let value = event.target.value;
            if (name === 'color') {
                value = serializeColor(value);
            } else if (['x', 'y', 'size', 'page'].indexOf(name) !== -1) {
                value = Number(value);
            }
            field[name] = value;
            renderPages();
            renderPalette();
        });

        removeButton.addEventListener('click', function () {
            if (!state.selectedFieldId) return;
            state.fields = state.fields.filter(function (field, index) {
                return fieldKey(field, index) !== state.selectedFieldId;
            });
            state.selectedFieldId = state.fields[0] ? fieldKey(state.fields[0], 0) : null;
            renderAll();
        });

        saveButton.addEventListener('click', function () {
            const saveUrl = root.dataset.saveUrl;
            if (!saveUrl) {
                status.textContent = 'No save URL configured.';
                return;
            }

            saveButton.disabled = true;
            status.textContent = 'Saving…';
            fetch(saveUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ fields: state.fields })
            })
                .then(function (response) { return response.json(); })
                .then(function (response) {
                    state.fields = Array.isArray(response.fields) ? response.fields : state.fields;
                    state.availableFields = Array.isArray(response.availableFields) ? response.availableFields : state.availableFields;
                    state.selectedFieldId = state.fields[0] ? fieldKey(state.fields[0], 0) : null;
                    status.textContent = 'Layout saved.';
                    renderAll();
                })
                .catch(function () {
                    status.textContent = 'Failed to save layout.';
                })
                .finally(function () {
                    saveButton.disabled = false;
                });
        });

        renderAll();
    }

    document.querySelectorAll('.dg-pdf-editor').forEach(boot);
})();
