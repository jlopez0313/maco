import { Link } from "@inertiajs/react";
import React from "react";
import Icon from "../Icon";
import ActionsTable from "./ActionsTable";

export default ({
    user = {},
    caption = "",
    data = [],
    routes = {},
    titles = [],
    actions = [],
    onTrash,
    onEdit,
    onSearch,
    onSort = () => {},
    sortIcon = "desc",
}) => {
    return (
        <table className="w-full whitespace-nowrap">
            <caption>{caption}</caption>

            <thead>
                <tr className="font-bold text-left">
                    {titles.map((title, key) => {
                        return (
                            <th className="px-6 pt-5 pb-4" key={key}>
                                {title.key ? (
                                    <div
                                        className="flex items-center cursor-pointer"
                                        onClick={() => onSort(title.key)}
                                    >
                                        <span> {title.title} </span>
                                        <Icon
                                            name={sortIcon == 'asc' ? 'chevron-up' : 'chevron-down'}
                                            className="flex-shrink-0 w-3 h-3 ml-2 fill-current"
                                        />
                                    </div>
                                ) : (
                                    <span> {title} </span>
                                )}
                            </th>
                        );
                    })}
                    <th className="px-6 pt-5 pb-4"> </th>
                </tr>
            </thead>
            <tbody>
                {data.map((item, key) => {
                    if (
                        item?.roles_adm?.length &&
                        !item.roles_adm.includes(user?.rol?.slug)
                    )
                        return;
                    return (
                        <tr
                            key={key}
                            className="hover:bg-gray-100 focus-within:bg-gray-100"
                            id={key}
                        >
                            {Object.keys(item).map((key, idx) => {
                                if (
                                    key == "id" ||
                                    key == "ruta" ||
                                    key == "estado" ||
                                    key == "roles_adm"
                                )
                                    return;
                                return (
                                    <td className="border-t" key={key}>
                                        <a
                                            role="button"
                                            onClick={() => onEdit(item.id)}
                                            className="flex items-center px-6 py-4 focus:text-indigo-700 focus:outline-none"
                                        >
                                            {item[key]}
                                            {idx == 0 && item.deleted_at && (
                                                <Icon
                                                    name="trash"
                                                    className="flex-shrink-0 w-3 h-3 ml-2 text-gray-400 fill-current"
                                                />
                                            )}
                                        </a>
                                    </td>
                                );
                            })}

                            <td className="w-px border-t">
                                {actions.map((action, key) => {
                                    if (action === "trash") {
                                        return (
                                            <ActionsTable
                                                key={key}
                                                action={action}
                                                onClick={() => onTrash(item.id)}
                                            />
                                        );
                                    } else if (
                                        action === "edit" &&
                                        (!item.estado || item.estado != "C")
                                    ) {
                                        return (
                                            <ActionsTable
                                                key={key}
                                                action={action}
                                                onClick={() => onEdit(item.id)}
                                            />
                                        );
                                    } else if (action === "search") {
                                        return (
                                            <ActionsTable
                                                key={key}
                                                action={action}
                                                onClick={() =>
                                                    onSearch(item.id)
                                                }
                                            />
                                        );
                                    }
                                })}
                            </td>
                        </tr>
                    );
                })}
                {data.length === 0 && (
                    <tr>
                        <td
                            className="px-6 py-4 border-t"
                            colSpan={titles.length + 1}
                        >
                            No data found.
                        </td>
                    </tr>
                )}
            </tbody>
        </table>
    );
};
