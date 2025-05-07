export class SeatStructure {
    constructor() {
        this.classes = [];
    }

    getClasses() {
        return this.classes;
    }

    setClasses(classes) {
        this.classes = classes;
        return this;
    }

    addClass(classType) {
        this.classes.push(new PlaneClass(classType));
        return this;
    }

    addClassCopy(planeClass) {
        this.classes.push(planeClass);
        return this;
    }

    delClass(planeClass) {
        const index = this.classes.indexOf(planeClass);
        if (index !== -1) {
            this.classes.splice(index, 1);
        }
        return this;
    }
}