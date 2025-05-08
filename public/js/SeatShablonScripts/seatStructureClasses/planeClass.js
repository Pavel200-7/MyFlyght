import { ClassZone } from "/js/SeatShablonScripts/seatStructureClasses/classZone.js";

export class PlaneClass {
    constructor(classType) {
        this.classType = classType;
        this.zones = [];
        this.addZone(); // создаем зону по умолчанию
    }

    deepClone() {
        const clone = new PlaneClass();
        clone.classType = this.classType;
        clone.zones = this.zones.map(zone => zone.deepClone());

        return clone;
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

        let objectCopy = classZone.deepClone();
        this.zones.push(objectCopy);
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