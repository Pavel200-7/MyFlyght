import { ClassZone } from "/js/SeatShablonScripts/seatStructureClasses/classZone.js";

export class PlaneClass {
    constructor(classType) {
        this.classType = classType;
        this.zones = [];
        this.addZone(); // создаем зону по умолчанию
    }

    getClassType() {
        return this.classType;
    }

    setClassType(classType) {
        this.classType = classType;
        return this;
    }

    getZones() {
        return this.zones;
    }

    setZones(zones) {
        this.zones = zones;
        return this;
    }

    addZone() {
        this.zones.push(new ClassZone());
        return this;
    }

    addZoneCopy(classZone) {
        this.zones.push(classZone);
        return this;
    }

    delZone(classZone) {
        const index = this.zones.indexOf(classZone);
        if (index !== -1) {
            this.zones.splice(index, 1);
        }
        return this;
    }
}