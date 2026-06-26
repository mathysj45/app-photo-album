class LightboxModel {
    constructor() {
        this.currentImageSrc = null;
    }

    setImage(src) {
        this.currentImageSrc = src;
    }

    getImage() {
        return this.currentImageSrc;
    }
}

class LightboxView {
    constructor() {
        this.createModal();
    }

    createModal() {
        this.modal = document.createElement('div');
        this.modal.id = 'lightbox-modal';
        this.modal.innerHTML = `
            <div class="lightbox-content">
                <span class="lightbox-close">&times;</span>
                <img id="lightbox-img" src="" alt="Aperçu plein écran">
            </div>
        `;
        document.body.appendChild(this.modal);
        
        this.imgElement = this.modal.querySelector('#lightbox-img');
        this.closeBtn = this.modal.querySelector('.lightbox-close');
    }

    bindCloseEvent(handler) {
        this.closeBtn.addEventListener('click', handler);
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) {
                handler();
            }
        });
    }

    render(imageSrc) {
        if (imageSrc) {
            this.imgElement.src = imageSrc;
            this.modal.style.display = 'flex';
        } else {
            this.modal.style.display = 'none';
            this.imgElement.src = '';
        }
    }
}

class LightboxController {
    constructor(model, view) {
        this.model = model;
        this.view = view;

        this.view.bindCloseEvent(this.handleClose.bind(this));
        this.bindTriggers();
    }

    bindTriggers() {
        const images = document.querySelectorAll('.photo-trigger');
        images.forEach(img => {
            img.addEventListener('click', (e) => {
                const src = e.target.getAttribute('src');
                this.model.setImage(src);
                this.view.render(this.model.getImage());
            });
        });
    }

    handleClose() {
        this.model.setImage(null);
        this.view.render(this.model.getImage());
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const model = new LightboxModel();
    const view = new LightboxView();
    const controller = new LightboxController(model, view);
});