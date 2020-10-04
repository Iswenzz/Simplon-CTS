import Formattable from "./Formattable";
import JsonSerializable from "../util/JsonSerializable";
import Model from "./Model";
import TypePlanque from "./TypePlanque";

class Planque extends Model implements JsonSerializable, Formattable
{
	private code: number | null;
	private adresse: string;
	private codePays: number | null;
	private typePlanque: TypePlanque;

	/**
	 * Initialize a new Planque object.
	 */
	public constructor(code: number | null = null, adresse = "", codePays: number | null = null, typePlanque: TypePlanque = null)
	{
		super();
		this.code = code;
		this.codePays = codePays;
		this.typePlanque = typePlanque;
		this.adresse = adresse;
	}

	/**
	 * Format the model data.
	 */
	public format(): string
	{
		return `${this.code} (${this.adresse})`;
	}

	/**
	 * Get the value of code
	 */ 
	public getCode(): number | null
	{
		return this.code;
	}

	/**
	 * Set the value of code
	 */ 
	public setCode(code: number | null): void
	{
		this.code = code;
	}

	/**
	 * Get the value of adresse
	 */ 
	public getAdresse(): string
	{
		return this.adresse;
	}

	/**
	 * Set the value of adresse
	 */ 
	public setAdresse(adresse: string): void
	{
		this.adresse = adresse;
	}

	/**
	 * Get the value of codePays
	 */ 
	public getCodePays(): number
	{
		return this.codePays;
	}

	/**
	 * Set the value of codePays
	 */ 
	public setCodePays(codePays: number): void
	{
		this.codePays = codePays;
	}

	/**
	 * Get the value of typePlanque
	 */ 
	public getTypePlanque(): TypePlanque
	{
		return this.typePlanque;
	}

	/**
	 * Set the value of typePlanque
	 */ 
	public setTypePlanque(typePlanque: TypePlanque): void
	{
		this.typePlanque = typePlanque;
	}

	/**
	 * Serialize the object.
	 */
	public jsonSerialize(): Record<string, unknown>
	{
		return {
			code: this.getCode(),
			adresse: this.getAdresse(),
			codePays: this.getCodePays(),
			typePlanque: this.getTypePlanque().jsonSerialize()
		};
	}
}

export default Planque;