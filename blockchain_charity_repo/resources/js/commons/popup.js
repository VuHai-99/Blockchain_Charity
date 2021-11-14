function defaultPopup(title, message, buttons, mainClass) {
    let id = `modal-${new Date().getTime()}-`;
    $('.js-default-ok-popup').remove();
    let html = `<!-- Modal -->
    <div class="modal fade js-default-ok-popup ${mainClass}" id="${id}" tabindex="-1" role="dialog" aria-labelledby="${id}Label" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="${id}Label">${title}</h5>
          </div>
          <div class="modal-body">
            ${message}
          </div>
          <div class="modal-footer">
          ${buttons}
          </div>
        </div>
      </div>
    </div>`;
    $('body').append(html);
    $(`#${id}`).css({
        zIndex: 100001
    }).modal('show');
    $('.modal-backdrop').css({ zIndex: 100000 });
    cssPopup();
    return id;
}

function showPopupOk(title = "", message = "", okButton = "OK", callback, mainClass = '') {
    let id = defaultPopup(title, message,
        okButton ? `<button type="button" class="btn-close btn btn-primary">${okButton}</button>` : '',
        mainClass
    );
    $(`#${id} .btn-close `).click(() => {
        $(`#${id}`).modal('hide');
        if (callback) {
            callback();
        }
    });
}

function showPopupYesNo(title = "", message = "", yesButton = "yes", noButton = "no", yesCallback, noCallback) {

    let id = defaultPopup(title, message, `
        <button type="button" class="btn-no btn btn-primary">${noButton}</button>
        <button type="button" class="btn-yes btn btn-primary">${yesButton}</button>
    `);

    $(`#${id} .btn-yes `).click(() => {
        $(`#${id}`).modal('hide');
        if (yesCallback) {
            yesCallback();
        }
    });
    $(`#${id} .btn-no `).click(() => {
        $(`#${id}`).modal('hide');
        if (noCallback) {
            noCallback();
        }
    });
}

window.showPopupOk = showPopupOk;
window.showPopupYesNo = showPopupYesNo;

function defaultPopupBackdrop(title, message, buttons) {
    let id = `modal-${new Date().getTime()}-`;
    $('.js-default-ok-popup').remove();
    let html = `<!-- Modal -->
      <div class="modal fade js-default-ok-popup" id="${id}" tabindex="-1" role="dialog" aria-labelledby="${id}Label" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="${id}Label">${title}</h5>
            </div>
            <div class="modal-body">
              ${message}
            </div>
            <div class="modal-footer">
            ${buttons}
            </div>
          </div>
        </div>
      </div>`;
    $('body').append(html);
    $(`#${id}`).modal('show');
    cssPopup();
    return id;

}

function showPopupOkBackdrop(title = "", message = "", okButton = "OK", callback) {
    let id = defaultPopupBackdrop(title, message, `<button type="button" class="btn-close btn btn-primary">${okButton}</button>`);
    $(`#${id} .btn-close `).click(() => {
        $(`#${id}`).modal('hide');
        if (callback) {
            callback();
        }
    });
}

function cssPopup() {
    $('.modal-body').css({
        "text-align": "center",
        "font-weight": "600"
    });
    $('.modal-footer ').css({
        "display": "flex",
        "justify-content": "space-around"
    });
    $('.modal-footer .btn-no').css({
        "width": "35%",
        "background": "#ececec",
        "color": "black",
        "border": "none",
    });
    $('.modal-footer .btn-yes').css({
        "width": "35%",
        "background": "#24aae1",
        "border": "none",
    });
    $('.modal-footer .btn-close').css({
        "width": "26%",
        "background": "#24aae1",
        "border": "none",
    });
}

window.showPopupOkBackdrop = showPopupOkBackdrop;
