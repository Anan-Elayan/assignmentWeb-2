<?php


class Product
{

    private int $id;
    private string $name;
    private string $category;
    private string $description;
    private int $price;
    private string $rating;
    private string $imageName;
    private int $quantity;

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getCategory()
    {
        return $this->category;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getRating()
    {
        return $this->price;
    }
    public function getImageName()
    {
        return $this->imageName;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }

    //to display each product in row in table
    public function displayInTable()
    {
        $deleteLink = "delete.php?id={$this->id}";
        $row = <<<REC
<tr>
    
    <td><figure ><img src="{$this->getImageName()}" alt="{$this->getName()}" style="max-width: 90px;" ></figure> </td>
    <td><a href="view.php?id={$this->getId()}">{$this->getId()}</a></td>
    <td>{$this->getName()}</td>
    <td>{$this->getCategory()}</td>
    <td>{$this->getPrice()}</td>
    <td>{$this->getQuantity()}</td>
    <td>
    <div>
        
        <button type="button"><a href="edit.php?id={$this->getId()}"><img src='./images/edit.png' alt='edit'></a></button>
        <button type="button"><a href="delete.php?id={$this->getId()}"><img src='./images/delete.png' alt='delete'></a></button>

    </div>
    </td>
</tr>
REC;
        return $row;
    }


    // to display each product in page 
    function displayProdcutPage()
    {
        $main = <<<REC
        <main>
            <article>
                <figure>
                    <img src="$this->imageName" alt="$this->name">
                </figure>
            </article>
    
            <section>
                <h1>Product ID: $this->id, $this->name</h1>
                <ul>
                    <li>Price: $this->price</li>
                    <li>Category: $this->category</li>
                    <li>Rating: $this->rating/5</li>
                </ul>
            </section>
    
            <section>
                <h1>Description:</h1>
                <p>$this->description</p>
            </section>
        </main>
    REC;

        return $main;
    }
}
