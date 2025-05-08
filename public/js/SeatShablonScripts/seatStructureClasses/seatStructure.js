import { PlaneClass } from "/js/SeatShablonScripts/seatStructureClasses/planeClass.js";
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
        let objectCopy = planeClass.deepClone();
        this.classes.push(objectCopy);
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