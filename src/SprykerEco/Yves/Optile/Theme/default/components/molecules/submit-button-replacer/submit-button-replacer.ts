import Component from 'ShopUi/models/component';

export default class SubmitButtonReplacer extends Component {
    protected triggers: HTMLInputElement[];
    protected targets: HTMLElement[];
    
    protected readyCallback(): void {}

    protected init(): void {
        this.triggers = <HTMLInputElement[]>Array.from(document.getElementsByClassName(this.triggerClassName));
        this.targets = <HTMLElement[]>Array.from(document.getElementsByClassName(`${this.jsName}__target`));

        this.initTargetsState();
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.mapTriggerChangeEvent();
    }

    protected mapTriggerChangeEvent(): void {
        this.triggers.forEach((trigger: HTMLInputElement) => {
           trigger.addEventListener('change', () => this.onTriggerChange(trigger));
        });
    }

    protected onTriggerChange(trigger: HTMLInputElement): void {
        this.toggleTargetsVisibility(trigger);
    }

    protected initTargetsState(): void {
        this.triggers.forEach((trigger: HTMLInputElement) => {
            this.toggleTargetsVisibility(trigger);
        });
    }

    protected toggleTargetsVisibility(trigger: HTMLInputElement): void {
        const submitButtonContainerClassName = trigger.getAttribute('submit-button-container-class-name');
        const submitButtonContainer = <HTMLElement>document.getElementsByClassName(submitButtonContainerClassName)[0];

        this.targets.forEach((target: HTMLElement) => target.classList.add(this.classToToggle));
        submitButtonContainer.classList.remove((this.classToToggle));
    }

    protected get triggerClassName(): string {
        return this.getAttribute('trigger-class-name');
    }

    protected get classToToggle(): string {
        return this.getAttribute('class-to-toggle');
    }
}
