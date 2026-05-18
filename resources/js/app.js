require('./bootstrap');

var backToTopButton = document.querySelector('[data-back-to-top]');

    if (backToTopButton) {
        function toggleBackToTopButton() {
            backToTopButton.classList.toggle('is-visible', window.scrollY > 360);
        }

        toggleBackToTopButton();

        window.addEventListener('scroll', toggleBackToTopButton, { passive: true });

        backToTopButton.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    document.querySelectorAll('[data-hover-dropdown]').forEach(function (dropdown) {
        if (!window.bootstrap) {
            return;
        }

        var toggle = dropdown.querySelector('.dropdown-toggle');
        var menu = dropdown.querySelector('.dropdown-menu');

        if (!toggle || !menu) {
            return;
        }

        var dropdownInstance = window.bootstrap.Dropdown.getOrCreateInstance(toggle);
        var hideTimer;

        function showDropdown() {
            clearTimeout(hideTimer);
            dropdownInstance.show();
        }

        function hideDropdown() {
            hideTimer = setTimeout(function () {
                dropdownInstance.hide();
            }, 140);
        }

        dropdown.addEventListener('mouseenter', showDropdown);
        dropdown.addEventListener('mouseleave', hideDropdown);
        dropdown.addEventListener('focusin', showDropdown);
        dropdown.addEventListener('focusout', function () {
            if (!dropdown.contains(document.activeElement)) {
                hideDropdown();
            }
        });
    });

    document.querySelectorAll('[data-search-form]').forEach(function (form) {
        var input = form.querySelector('[data-search-input]');
        var button = form.querySelector('[data-search-button]');
        var suggestions = form.querySelector('[data-search-suggestions]');
        var suggestionItems = [];
        var activeSuggestionIndex = -1;
        var suggestionTimer;
        var suggestionController;

        if (!input) {
            return;
        }

        function updateSearchButton() {
            if (!button) {
                return;
            }

            button.disabled = input.value.trim().length < 2;
        }

        updateSearchButton();

        function escapeHtml(value) {
            return String(value).replace(/[&<>"']/g, function (character) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                }[character];
            });
        }

        function hideSuggestions() {
            if (!suggestions) {
                return;
            }

            suggestions.classList.remove('is-visible');
            suggestions.innerHTML = '';
            suggestionItems = [];
            activeSuggestionIndex = -1;
        }

        function setActiveSuggestion(index) {
            activeSuggestionIndex = index;

            suggestionItems.forEach(function (item, itemIndex) {
                item.classList.toggle('is-active', itemIndex === activeSuggestionIndex);
            });
        }

        function renderSuggestions(data, query) {
            if (!suggestions) {
                return;
            }

            var products = data.products || [];
            var categories = data.categories || [];

            if (!products.length && !categories.length) {
                hideSuggestions();
                return;
            }

            var html = '';

            if (products.length) {
                html += '<div class="search-suggestions-section">';
                html += '<span class="search-suggestions-title">Products</span>';
                products.forEach(function (product) {
                    html += '<a class="search-suggestion-item" href="' + escapeHtml(product.url) + '">';
                    html += '<span class="search-suggestion-image"><img src="' + escapeHtml(product.image) + '" alt=""></span>';
                    html += '<span class="search-suggestion-copy"><strong>' + escapeHtml(product.name) + '</strong><small>' + escapeHtml(product.category) + ' · ' + escapeHtml(product.price) + '</small></span>';
                    html += '</a>';
                });
                html += '</div>';
            }

            if (categories.length) {
                html += '<div class="search-suggestions-section search-suggestions-section-secondary">';
                html += '<span class="search-suggestions-title">Categories</span>';
                categories.forEach(function (category) {
                    html += '<a class="search-suggestion-item search-suggestion-category" href="' + escapeHtml(category.url) + '">';
                    html += '<span class="search-suggestion-icon" aria-hidden="true">#</span>';
                    html += '<span class="search-suggestion-copy"><strong>' + escapeHtml(category.label) + '</strong><small>Browse category</small></span>';
                    html += '</a>';
                });
                html += '</div>';
            }

            html += '<a class="search-suggestion-all" href="' + escapeHtml(form.action) + '?query=' + encodeURIComponent(query) + '">View all results</a>';

            suggestions.innerHTML = html;
            suggestions.classList.add('is-visible');
            suggestionItems = Array.prototype.slice.call(suggestions.querySelectorAll('a'));
            activeSuggestionIndex = -1;
        }

        function loadSuggestions() {
            if (!suggestions) {
                return;
            }

            var query = input.value.trim();

            if (query.length < 2) {
                hideSuggestions();
                return;
            }

            clearTimeout(suggestionTimer);
            suggestionTimer = setTimeout(function () {
                if (suggestionController) {
                    suggestionController.abort();
                }

                suggestionController = new AbortController();

                fetch('/search/suggestions?query=' + encodeURIComponent(query), {
                    headers: {
                        'Accept': 'application/json'
                    },
                    signal: suggestionController.signal
                })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Search suggestions unavailable');
                    }

                    return response.json();
                })
                .then(function (data) {
                    renderSuggestions(data, query);
                })
                .catch(function (error) {
                    if (error.name !== 'AbortError') {
                        hideSuggestions();
                    }
                });
            }, 160);
        }

        form.addEventListener('submit', function (event) {
            var query = input.value.trim();

            input.value = query;

            if (query.length === 0) {
                event.preventDefault();
                window.location.href = form.action;

                return;
            }

            if (query.length < 2) {
                event.preventDefault();
                input.setCustomValidity('Please enter at least 2 letters.');
                input.reportValidity();

                return;
            }

            input.setCustomValidity('');
        });

        input.addEventListener('input', function () {
            input.setCustomValidity('');
            updateSearchButton();
            loadSuggestions();
        });

        input.addEventListener('focus', loadSuggestions);

        input.addEventListener('keydown', function (event) {
            if (!suggestionItems.length) {
                return;
            }

            if (event.key === 'ArrowDown') {
                event.preventDefault();
                setActiveSuggestion((activeSuggestionIndex + 1) % suggestionItems.length);
                return;
            }

            if (event.key === 'ArrowUp') {
                event.preventDefault();
                setActiveSuggestion((activeSuggestionIndex - 1 + suggestionItems.length) % suggestionItems.length);
                return;
            }

            if (event.key === 'Enter' && activeSuggestionIndex >= 0) {
                event.preventDefault();
                suggestionItems[activeSuggestionIndex].click();
                return;
            }

            if (event.key === 'Escape') {
                hideSuggestions();
            }
        });

        document.addEventListener('click', function (event) {
            if (!form.contains(event.target)) {
                hideSuggestions();
            }
        });
    });

    document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
        var input = document.querySelector(button.getAttribute('data-password-toggle'));

        if (!input) {
            return;
        }

        button.addEventListener('click', function () {
            var shouldShow = input.type === 'password';

            input.type = shouldShow ? 'text' : 'password';
            button.classList.toggle('is-visible', shouldShow);
            button.setAttribute('aria-pressed', shouldShow ? 'true' : 'false');
            button.setAttribute('aria-label', shouldShow ? 'Hide password' : 'Show password');
        });
    });

    var cancelOrderModal = document.getElementById('cancelOrderModal');

    if (cancelOrderModal && window.bootstrap) {
        var cancelModal = new window.bootstrap.Modal(cancelOrderModal);
        var cancelOrderId = document.getElementById('cancel_order_id');
        var cancelOrderName = document.getElementById('cancel_order_name');
        var cancelReasonGroup = document.getElementById('cancel_reason_group');
        var cancelReasonDetails = document.getElementById('cancel_reason_details');

        document.querySelectorAll('[data-cancel-order]').forEach(function (button) {
            button.addEventListener('click', function () {
                cancelOrderId.value = button.getAttribute('data-cancel-order');
                cancelOrderName.textContent = 'Tell us why you want to cancel ' + button.getAttribute('data-order-name') + '.';
                cancelReasonGroup.value = '';
                cancelReasonDetails.value = '';
                cancelModal.show();
            });
        });
    }

    document.querySelectorAll('[data-ajax-wishlist]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            var button = form.querySelector('.wishlist-button');

            if (button) {
                button.disabled = true;
            }

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('Wishlist request failed');
                }

                return response.json();
            })
            .then(function (data) {
                var countBadge = document.querySelector('.wishlist-count');
                var wishlistLink = document.querySelector('.wishlist-link');
                var wishlistCount = Number(data.wishlist_count) || 0;

                if (button) {
                    button.classList.toggle('is-liked', Boolean(data.wishlisted));
                    button.setAttribute('aria-label', data.wishlisted ? 'Remove from wishlist' : 'Add to wishlist');

                    var buttonLabel = button.querySelector('span');

                    if (buttonLabel) {
                        buttonLabel.textContent = data.wishlisted ? 'Wishlisted' : 'Wishlist';
                    }
                }

                if (form.dataset.addUrl && form.dataset.removeUrl) {
                    form.action = data.wishlisted ? form.dataset.removeUrl : form.dataset.addUrl;
                }

                if (wishlistLink && wishlistCount > 0 && !countBadge) {
                    countBadge = document.createElement('span');
                    countBadge.className = 'wishlist-count';
                    wishlistLink.appendChild(countBadge);
                }

                if (countBadge) {
                    if (wishlistCount > 0) {
                        countBadge.textContent = wishlistCount;
                    } else {
                        countBadge.remove();
                    }
                }

                if (!data.wishlisted && form.hasAttribute('data-remove-card')) {
                    var wishlistItem = form.closest('[data-wishlist-item]');
                    var wishlistGrid = document.querySelector('[data-wishlist-grid]');
                    var emptyState = document.querySelector('[data-wishlist-empty]');

                    if (wishlistItem) {
                        wishlistItem.remove();
                    }

                    if (wishlistGrid && emptyState && !wishlistGrid.querySelector('[data-wishlist-item]')) {
                        emptyState.classList.remove('d-none');
                    }
                }
            })
            .catch(function () {
                form.submit();
            })
            .finally(function () {
                if (button) {
                    button.disabled = false;
                }
            });
        });
    });

    document.querySelectorAll('[data-ajax-cart]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            var button = form.querySelector('button[type="submit"]');
            var originalLabel = button ? button.textContent.trim() : '';

            if (button) {
                button.disabled = true;
            }

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('Cart request failed');
                }

                return response.json();
            })
            .then(function (data) {
                var cartLink = document.querySelector('.cart-link');
                var cartBadge = document.querySelector('.cart-count');
                var cartCount = Number(data.cart_count) || 0;

                if (cartLink && cartCount > 0 && !cartBadge) {
                    cartBadge = document.createElement('span');
                    cartBadge.className = 'cart-count';
                    cartLink.appendChild(cartBadge);
                }

                if (cartBadge) {
                    cartBadge.textContent = cartCount;
                    cartBadge.classList.remove('cart-count-pulse');
                    void cartBadge.offsetWidth;
                    cartBadge.classList.add('cart-count-pulse');
                }

                if (cartLink) {
                    cartLink.setAttribute('aria-label', 'Open cart with ' + cartCount + ' items');
                }

                if (button) {
                    button.classList.add('is-added');
                    button.dataset.cartAdded = 'true';
                    button.lastChild.textContent = ' Added to cart';
                }
            })
            .catch(function () {
                form.submit();
            })
            .finally(function () {
                if (!button) {
                    return;
                }

                window.setTimeout(function () {
                    button.disabled = false;
                    button.classList.remove('is-added');

                    if (originalLabel) {
                        button.lastChild.textContent = ' ' + originalLabel;
                    }
                }, 650);
            });
        });
    });

    function updateCartPage(form, data) {
        var row = form.closest('[data-cart-item]');
        var quantity = Number(data.quantity) || 0;
        var maxQuantity = Number(data.max_quantity) || 3;
        var summaryItems = document.querySelector('[data-cart-summary-items]');
        var summaryTotal = document.querySelector('[data-cart-summary-total]');
        var checkoutButton = document.querySelector('[data-order-confirm]');
        var confirmTotal = document.querySelector('[data-order-confirm-total]');
        var cartBadge = document.querySelector('.cart-count');
        var cartLink = document.querySelector('.cart-link');
        var cartCount = Number(data.cart_count) || 0;

        if (row && quantity < 1) {
            row.remove();
        } else if (row) {
            var input = row.querySelector('.quantity-value');
            var subtotal = row.querySelector('[data-cart-row-subtotal]');
            var increaseButton = row.querySelector('form[action="/increasecart"] .quantity-button');

            if (input) {
                input.value = quantity;
                input.dataset.originalValue = quantity;
            }

            if (subtotal) {
                subtotal.textContent = data.subtotal;
            }

            if (increaseButton) {
                increaseButton.disabled = quantity >= maxQuantity;
            }
        }

        if (summaryItems) {
            summaryItems.textContent = cartCount;
        }

        if (summaryTotal) {
            summaryTotal.textContent = data.cart_total;
        }

        if (checkoutButton) {
            checkoutButton.setAttribute('data-cart-total', data.cart_total);
        }

        if (confirmTotal) {
            confirmTotal.textContent = data.cart_total;
        }

        if (cartLink && cartCount > 0 && !cartBadge) {
            cartBadge = document.createElement('span');
            cartBadge.className = 'cart-count';
            cartLink.appendChild(cartBadge);
        }

        if (cartBadge) {
            if (cartCount > 0) {
                cartBadge.textContent = cartCount;
                cartBadge.classList.remove('cart-count-pulse');
                void cartBadge.offsetWidth;
                cartBadge.classList.add('cart-count-pulse');
            } else {
                cartBadge.remove();
            }
        }

        if (cartLink) {
            cartLink.setAttribute('aria-label', 'Open cart with ' + cartCount + ' items');
        }

        if (cartCount < 1) {
            window.location.reload();
        }
    }

    function submitCartPageForm(form) {
        if (form.dataset.pending === 'true') {
            return;
        }

        var buttons = form.querySelectorAll('button');

        form.dataset.pending = 'true';
        buttons.forEach(function (button) {
            button.disabled = true;
        });

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(function (response) {
            if (!response.ok) {
                throw new Error('Cart update failed');
            }

            return response.json();
        })
        .then(function (data) {
            updateCartPage(form, data);
        })
        .catch(function () {
            form.submit();
        })
        .finally(function () {
            form.dataset.pending = 'false';
            buttons.forEach(function (button) {
                button.disabled = false;
            });

            var row = form.closest('[data-cart-item]');

            if (row) {
                var input = row.querySelector('.quantity-value');
                var increaseButton = row.querySelector('form[action="/increasecart"] .quantity-button');

                if (input && increaseButton) {
                    increaseButton.disabled = Number(input.value) >= (Number(input.max) || 3);
                }
            }
        });
    }

    document.querySelectorAll('[data-cart-control-form]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            submitCartPageForm(form);
        });
    });

    document.querySelectorAll('[data-cart-quantity-form]').forEach(function (form) {
        var input = form.querySelector('.quantity-value');

        if (!input) {
            return;
        }

        input.dataset.originalValue = input.value;

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            submitCartPageForm(form);
        });

        input.addEventListener('change', function () {
            var nextValue = Number(input.value);
            var maxValue = Number(input.max) || 3;
            var originalValue = input.dataset.originalValue || input.defaultValue;

            if (!Number.isFinite(nextValue) || nextValue < 1) {
                input.value = originalValue;
                return;
            }

            input.value = Math.min(maxValue, Math.floor(nextValue));

            if (String(input.value) === String(originalValue)) {
                return;
            }

            submitCartPageForm(form);
        });
    });

    document.querySelectorAll('[data-order-confirm]').forEach(function (button) {
        button.addEventListener('click', function (event) {
            var modalElement = document.getElementById('orderConfirmModal');
            var totalElement = document.querySelector('[data-order-confirm-total]');
            var yesButton = document.querySelector('[data-order-confirm-yes]');
            var href = button.getAttribute('href');
            var total = button.getAttribute('data-cart-total') || '';

            if (totalElement) {
                totalElement.textContent = total;
            }

            if (yesButton && href) {
                yesButton.setAttribute('href', href);
            }

            if (modalElement && window.bootstrap) {
                event.preventDefault();
                new window.bootstrap.Modal(modalElement).show();
                return;
            }

            if (!window.confirm('Are you sure you want to place this order? Total: ' + total)) {
                event.preventDefault();
            }
        });
    });

    document.querySelectorAll('[data-country-select]').forEach(function (countrySelect) {
        var form = countrySelect.closest('form');
        var phoneInput = form ? form.querySelector('[data-phone-input]') : null;

        if (!phoneInput) {
            return;
        }

        function selectedPhoneCode() {
            var option = countrySelect.options[countrySelect.selectedIndex];

            return option ? option.getAttribute('data-phone-code') : '';
        }

        countrySelect.dataset.currentPhoneCode = selectedPhoneCode();

        if (!phoneInput.value.trim()) {
            phoneInput.value = countrySelect.dataset.currentPhoneCode;
        }

        countrySelect.addEventListener('change', function () {
            var previousCode = countrySelect.dataset.currentPhoneCode || '';
            var nextCode = selectedPhoneCode();
            var currentPhone = phoneInput.value.trim();

            if (!currentPhone || currentPhone === previousCode || currentPhone.indexOf(previousCode + ' ') === 0) {
                phoneInput.value = nextCode;
            } else if (previousCode && currentPhone.indexOf(previousCode) === 0) {
                phoneInput.value = nextCode + currentPhone.slice(previousCode.length);
            } else {
                phoneInput.value = nextCode + ' ' + currentPhone.replace(/^\+\d+\s*/, '');
            }

            countrySelect.dataset.currentPhoneCode = nextCode;
            phoneInput.focus();
        });
    });

    var addressForm = document.querySelector('[data-address-form]');

    if (addressForm) {
        var addressTitle = addressForm.querySelector('[data-address-form-title]');
        var addressId = addressForm.querySelector('[data-address-id]');
        var addressSubmit = addressForm.querySelector('[data-address-submit]');
        var addressCancel = addressForm.querySelector('[data-address-cancel]');
        var countrySelect = addressForm.querySelector('[data-country-select]');

        function setAddressFormMode(mode) {
            var isEditing = mode === 'edit';

            addressForm.action = isEditing ? '/addresses/update' : '/addresses';
            addressTitle.textContent = isEditing ? 'Edit address' : 'Add address';
            addressSubmit.textContent = isEditing ? 'Update address' : 'Save address';
            addressCancel.classList.toggle('d-none', !isEditing);

            if (!isEditing) {
                addressId.value = '';
                addressForm.reset();

                if (countrySelect) {
                    countrySelect.dispatchEvent(new Event('change'));
                }
            }
        }

        document.querySelectorAll('[data-edit-address]').forEach(function (button) {
            button.addEventListener('click', function () {
                setAddressFormMode('edit');

                addressId.value = button.dataset.id || '';
                addressForm.elements.label.value = button.dataset.label || '';
                addressForm.elements.street.value = button.dataset.street || '';
                addressForm.elements.apartment.value = button.dataset.apartment || '';
                addressForm.elements.city.value = button.dataset.city || '';
                addressForm.elements.postal_code.value = button.dataset.postalCode || '';
                addressForm.elements.country.value = button.dataset.country || '';
                addressForm.elements.phone.value = button.dataset.phone || '';

                if (countrySelect) {
                    var option = countrySelect.options[countrySelect.selectedIndex];
                    countrySelect.dataset.currentPhoneCode = option ? option.getAttribute('data-phone-code') : '';
                }

            });
        });

        addressCancel.addEventListener('click', function () {
            setAddressFormMode('add');
        });
    }

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('[data-checkout-confirmation]');
    const modal = document.querySelector('[data-checkout-confirmation-modal]');

    if (!form || !modal) {
      return;
    }

    const total = modal.querySelector('[data-checkout-confirmation-total]');
    const yesButton = modal.querySelector('[data-checkout-confirmation-yes]');
    const submitButton = form.querySelector('button[type="submit"]');
    const checkoutModal = window.bootstrap ? new window.bootstrap.Modal(modal) : null;

    form.addEventListener('submit', function (event) {
      if (form.dataset.confirmed === 'true') {
        if (submitButton) {
          submitButton.disabled = true;
          submitButton.textContent = 'Placing order...';
        }
        return;
      }

      event.preventDefault();

      if (total) {
        total.textContent = form.dataset.orderTotal || total.textContent;
      }

      if (checkoutModal) {
        checkoutModal.show();
        return;
      }

      if (window.confirm('Are you sure you want to place this order? Total: ' + (form.dataset.orderTotal || ''))) {
        form.dataset.confirmed = 'true';
        form.requestSubmit();
      }
    });

    yesButton.addEventListener('click', function () {
      yesButton.disabled = true;
      yesButton.textContent = 'Placing order...';
      form.dataset.confirmed = 'true';
      if (checkoutModal) {
        checkoutModal.hide();
      }
      form.requestSubmit();
    });
  });
