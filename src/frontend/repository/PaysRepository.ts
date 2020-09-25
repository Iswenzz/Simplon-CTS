import Axios from "axios";
import Pays from "../model/Pays";
import Deserializer from "../util/Deserializer";
import Repository from "./Repository";

export default class PaysRepository implements Repository {
	public async getAll(): Promise<Pays[]> {
		const response =  await Axios.post("../src/backend/php/api/PaysAPI.php", {
			method: "getAll"
		});

		const res : Pays[] = [];

		for (const pays of response.data.body) {
			res.push(new Deserializer(new Pays(), pays).deserialize());
		}

		return res;
	}
	
	public async get(model: Pays): Promise<Pays> {
		const response =  await Axios.post("../src/backend/php/api/PaysAPI.php", {
			method: "get",
			code: model.getCode()
		});

		return new Deserializer(new Pays(), response.data.body).deserialize();
	}
	
	add(model: Pays): Promise<boolean> {
		throw new Error("Method not implemented.");
	}
	delete(model: Pays): Promise<boolean> {
		throw new Error("Method not implemented.");
	}
	update(model: Pays): Promise<Pays> {
		throw new Error("Method not implemented.");
	}

}