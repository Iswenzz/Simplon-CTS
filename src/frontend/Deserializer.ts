class Deserializer<T>
{
	public instance: T;
	public data: unknown;

	public constructor(instance: T, data: unknown)
	{
		this.instance = instance;
		this.data = data;
	}

	public deserialize(): T
	{
		Object.assign(this.instance, this.data);
		return this.instance;
	}
}

export default Deserializer;