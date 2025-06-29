(() => {
    class Marquee {
        constructor(element, speed = 50) {
            this.element = element;
            this.speed = speed;

            this.content = element.firstElementChild;

            if (!this.validate()) return;

            this.init();
        }

        validate() {
            if (this.element.children.length !== 1) {
                console.error("❌ Marquee element must have exactly one direct child.");
                return false;
            }
            if (!this.content) {
                console.error("❌ Marquee content is missing.");
                return false;
            }
            return true;
        }

        init() {
            this.elementWidth = this.element.offsetWidth;
            this.contentWidth = this.content.offsetWidth;

            // Guardar los clones para manipulación futura
            this.clones = [this.content];

            // Duplicar contenido para cubrir el ancho del contenedor
         //   const requiredCopies = Math.ceil(this.elementWidth / this.contentWidth) + 1;
            const requiredCopies = Math.ceil((this.elementWidth * 2) / this.contentWidth) + 2;

            for (let i = 0; i < requiredCopies; i++) {
                const clone = this.content.cloneNode(true);
                clone.setAttribute('aria-hidden', 'true');
                this.element.appendChild(clone);
                this.clones.push(clone);
            }

            this.setAnimationDuration();
            this.startAnimation();

            // Resize handling
            this.resizeObserver = new ResizeObserver(() => this.onResize());
            this.resizeObserver.observe(this.element);
        }

        setAnimationDuration() {
            const pxPerSecond = this.speed;
            this.animationDuration = (this.contentWidth / pxPerSecond) * 1000; // ms
        }

        startAnimation() {
            // Cancel previous animation if any
            if (this.animation) {
                this.animation.cancel();
            }

            this.animation = this.element.animate([
                { transform: 'translateX(0)' },
                { transform: `translateX(-${this.contentWidth}px)` }
            ], {
                duration: this.animationDuration,
                iterations: Infinity,
                easing: 'linear'
            });
        }

        onResize() {
            const newWidth = this.element.offsetWidth;
            if (newWidth !== this.elementWidth) {
                this.reset();
            }
        }

        reset() {
            // Limpiar clones excepto el original
            while (this.element.children.length > 1) {
                this.element.removeChild(this.element.lastChild);
            }

            // Recalcular y reinicializar
            this.init();
        }

        setSpeed(newSpeed) {
            this.speed = newSpeed;
            this.setAnimationDuration();
            this.startAnimation();
        }

        pause() {
            if (this.animation) {
                this.animation.pause();
            }
        }

        play() {
            if (this.animation) {
                this.animation.play();
            }
        }

        destroy() {
            if (this.resizeObserver) {
                this.resizeObserver.disconnect();
            }
            if (this.animation) {
                this.animation.cancel();
            }
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.row-marquee').forEach(el => {
        //    const speedAttr = parseInt(el.dataset.speed, 50);
          //  const speed = isNaN(speedAttr) ? 10 : speedAttr;
            const speedAttr = parseInt(el.dataset.speed, 10);
            const speed = isNaN(speedAttr) ? 100 : speedAttr;

            new Marquee(el, speed);
        });
    });
})();