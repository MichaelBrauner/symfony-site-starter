import {Controller} from "stimulus"
import { useClickOutside, useTransition } from 'stimulus-use'

export default class extends Controller {

    static targets = ['opener', 'content']

    #open = false

    connect() {
        useClickOutside(this)
        useTransition(this, { element: this.contentTarget })

        if (this.hasOpenerTarget) {

            this.updateTargetVisibility()

            this.openerTarget.addEventListener('click', () => {
                this.toggleState()
                this.updateTargetVisibility()
            })
        }
    }

    toggleState() {
        this.#open = !this.#open
    }

    updateTargetVisibility() {
        const opener = this.openerTarget
        const target = this.contentTarget

        if (this.#open) {
            target.style.display = 'block'
            opener.setAttribute('aria-expanded', this.#open)
        } else {
            target.style.display = 'none'
            opener.setAttribute('aria-expanded', this.#open)

        }
    }

    clickOutside(event) {
        if (this.#open) {
            event.preventDefault()
            this.toggleState()
            this.updateTargetVisibility()
        }
    }

}