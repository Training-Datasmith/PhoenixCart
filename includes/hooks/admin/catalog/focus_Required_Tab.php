<?php

declare (strict_types=1);
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/
class Hook_admin_catalog_focus_Required_Tab
{
    public function listen_inject_site_end(): string
    {
        return <<<'ft'
        <script>
        document.addEventListener('DOMContentLoaded', function () {
          document.querySelectorAll('button[type="submit"]').forEach(function (button) {
            button.addEventListener('click', function () {
              var invalidElement = Array.from(document.querySelectorAll('.tab-pane :required:invalid')).find(function (input) {
                return input.closest('.tab-pane');
              });
        
              if (invalidElement) {
                var tabPane = invalidElement.closest('.tab-pane');
                var tabId = tabPane ? tabPane.id : null;
        
                if (tabId) {
                  var tabLink = document.querySelector('.nav a[href="#' + tabId + '"]');
                  if (tabLink) {
                    var tabEvent = new Event('click');
                    tabLink.dispatchEvent(tabEvent);
                  }
                }
        
                var collapseSection = invalidElement.closest('.collapse');
                if (collapseSection) {
                  collapseSection.classList.add('show');
                }
        
                document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(function (tab) {
                  tab.addEventListener('shown.bs.tab', function () {
                    var form = document.querySelector("form[name='new_product']");
                    if (form) {
                      form.reportValidity();
                    }
                  });
                });
              }
            });
          });
        });
        
        </script>
        ft;
    }
}