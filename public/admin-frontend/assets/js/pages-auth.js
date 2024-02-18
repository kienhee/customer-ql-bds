/**
 * Trang Xác thực
 */

'use strict';
const formAuthentication = document.querySelector('#formAuthentication');

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    // Kiểm tra hợp lệ của biểu mẫu để Thêm bản ghi mới
    if (formAuthentication) {
      const fv = FormValidation.formValidation(formAuthentication, {
        fields: {
          full_name: {
            validators: {
              notEmpty: {
                message: 'Vui lòng nhập họ và tên'
              },
              stringLength: {
                min: 6,
                message: 'Tên người dùng phải có hơn 6 ký tự'
              }
            }
          },
          phone: {
            validators: {
              notEmpty: {
                message: 'Vui lòng nhập số điện thoại của bạn'
              },
              regexp: {
                regexp: /^[0-9\s]+$/,
                message: 'Vui lòng nhập số điện thoại hợp lệ'
              }
            }
          },
          CCCD: {
            validators: {
              notEmpty: {
                message: 'Vui lòng nhập số CCCD/CMND'
              },
              regexp: {
                regexp: /^[0-9\s]+$/,
                message: 'Vui lòng nhập CCCD/CMND hợp lệ'
              }
            }
          },
          referralCode: {
            validators: {
              notEmpty: {
                message: 'Vui lòng nhập mã giới thiệu'
              },
              stringLength: {
                min: 6,
                message: 'Mã giới thiệu phải có hơn 6 ký tự'
              }
            }
          },
          email: {
            validators: {
              notEmpty: {
                message: 'Vui lòng nhập địa chỉ email của bạn'
              },
              emailAddress: {
                message: 'Vui lòng nhập địa chỉ email hợp lệ'
              }
            }
          },
          'email-username': {
            validators: {
              notEmpty: {
                message: 'Vui lòng nhập email / tên người dùng'
              },
              stringLength: {
                min: 6,
                message: 'Tên người dùng phải có hơn 6 ký tự'
              }
            }
          },
          password: {
            validators: {
              notEmpty: {
                message: 'Vui lòng nhập mật khẩu của bạn'
              },
              stringLength: {
                min: 6,
                message: 'Mật khẩu phải có hơn 6 ký tự'
              }
            }
          },
          'password_confirmation': {
            validators: {
              notEmpty: {
                message: 'Vui lòng xác nhận mật khẩu'
              },
              identical: {
                compare: function () {
                  return formAuthentication.querySelector('[name="password"]').value;
                },
                message: 'Mật khẩu và mật khẩu xác nhận không giống nhau'
              },
              stringLength: {
                min: 6,
                message: 'Mật khẩu phải có hơn 6 ký tự'
              }
            }
          },
          terms: {
            validators: {
              notEmpty: {
                message: 'Vui lòng đồng ý các điều khoản & điều kiện'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: '.mb-3'
          }),
          submitButton: new FormValidation.plugins.SubmitButton(),

          defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
          autoFocus: new FormValidation.plugins.AutoFocus()
        },
        init: instance => {
          instance.on('plugins.message.placed', function (e) {
            if (e.element.parentElement.classList.contains('input-group')) {
              e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
            }
          });
        }
      });
    }

    // Xác thực hai bước
    const numeralMask = document.querySelectorAll('.numeral-mask');

    // Mặt nạ xác thực
    if (numeralMask.length) {
      numeralMask.forEach(e => {
        new Cleave(e, {
          numeral: true
        });
      });
    }
  })();
});
