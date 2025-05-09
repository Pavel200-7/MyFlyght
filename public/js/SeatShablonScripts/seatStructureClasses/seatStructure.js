import { planeClass } from "/js/SeatShablonScripts/seatStructureClasses/planeClass.js";
export class seatStructure {
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
        this.classes.push(new planeClass(classType));
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